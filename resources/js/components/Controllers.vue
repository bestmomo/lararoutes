<template>
    <div>
        <ul class="collection">
            <li v-for="text in texts" :key="text.name" class="collection-item">
                <pre>{{ text }}</pre>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data () {
            return {
                texts: [],
                prefix: [],
                controllers: []
            }
        },
        methods: {
            reset() {
                this.controllers = [];
            },
            setPrefix(prefix) {
                return this.setElement(this.prefix, prefix, '/');
            },
            setElement(elements, element, separator) {
                if(elements.length) {
                    let el = '';
                    elements.forEach(e => {
                        if(e != '') el += e + separator;
                    });
                    if(element == '') return el.slice(0, -1);
                    return el + element;
                }
                return element;
            },
            checkAbsent(value) {
                return !this.controllers.some(e => {
                    return e.name == value;
                });
            },
            addMethod(controller, method) {
                this.controllers.forEach(e => {
                    if(e.name == controller) {
                        if(!e.functions.includes(method)) {
                            e.functions.push(method);
                        }
                    }
                });
            },
            getParams(text) {
                const regex = /{(.*?)}/g;
                let found = text.match(regex).map(el => el.slice(1, -1));
                if(found) {
                    return found.map(function(e) { return '$' + e });
                }
                else return [];
            },
            loop(element) {
                element.forEach(e => {
                    let u = 0;
                    if(e.type == 'group') {
                        this.prefix.push(e.prefix);
                        if(e.items) {
                            this.loop(e.items);
                        }
                        this.prefix.pop();
                    } else if(e.type == 'route' && e.subType == 'method') {
                        let controller = e.content.split('@')[0];
                        if(this.checkAbsent(controller)) {
                            this.controllers.push({'name': controller, 'functions': []});
                        }
                        let uri = this.setPrefix(e.url);
                        let params = this.getParams(uri);
                        let method = e.content.split('@')[1];
                        this.addMethod(controller, [method, params]);
                    } else if(e.type == 'resource') {
                        let f = [1,1,1,1,1,1,1];
                        let controller = e.controller;
                        if(this.checkAbsent(controller)) {
                            this.controllers.push({'name': controller, 'functions': []});
                        }
                        if(e.index || e.create || e.store || e.show || e.edit || e.update || e.destroy) {
                            if(e.partial == 'only') {
                                f = [0,0,0,0,0,0,0];
                                if(e.index) f[0] = true;
                                if(e.create) f[1] = true;
                                if(e.store) f[2] = true;
                                if(e.show) f[3] = true;
                                if(e.edit) f[4] = true;
                                if(e.update) f[5] = true;
                                if(e.destroy) f[6] = true;
                            } else {
                                if(e.index) f[0] = false;
                                if(e.create) f[1] = false;
                                if(e.store) f[2] = false;
                                if(e.show) f[3] = false;
                                if(e.edit) f[4] = false;
                                if(e.update) f[5] = false;
                                if(e.destroy) f[6] = false;
                            }
                        }
                        if(f[0]) this.addMethod(controller, ['index']);
                        if(f[2]) this.addMethod(controller, ['store']);
                        if(f[1]) this.addMethod(controller, ['create']);
                        if(f[3]) this.addMethod(controller, ['show']);
                        if(f[5]) this.addMethod(controller, ['update']);
                        if(f[6]) this.addMethod(controller, ['destroy']);
                        if(f[4]) this.addMethod(controller, ['edit']);
                    }
                })
            },
            generate() {
                this.texts = [];
                const tab = '    ';
                this.controllers.forEach(controller => {
                    let el = '<?php\n\nnamespace App\\Http\\Controllers;\n\nuse App\\Http\\Controllers\\Controller;\n\nclass ';
                    el += controller.name + ' extends Controller\n{\n';
                    controller.functions.forEach(method => {
                        switch (method[0]) {
                            case 'index':
                                el += this.generateDoc('Display a listing of the resource.', [])
                                break;
                            case 'create':
                                el += this.generateDoc('Show the form for creating a new resource.', [])
                                break;
                            case 'store':
                                el += this.generateDoc('Store a newly created resource in storage.',
                                    ['\\Illuminate\\Http\\Request  $request']);
                                break;
                            case 'show':
                                el += this.generateDoc('Display the specified resource.',
                                    ['int  $id']);
                                break;
                            case 'edit':
                                el += this.generateDoc('Show the form for editing the specified resource.',
                                    ['int  $id']);
                                break;
                            case 'update':
                                el += this.generateDoc('Update the specified resource in storage.', [
                                    '\\Illuminate\\Http\\Request  $request',
                                    'int  $id']);
                                break;
                            case 'destroy':
                                el += this.generateDoc('Remove the specified resource from storage.',
                                    ['int  $id']);
                                break;
                            default:
                                el += this.generateDoc('Some elements there.', method[1]);
                        }
                        el += tab + 'public function ' + method[0] + '(';
                        switch (method[0]) {
                            case 'store':
                                el += 'Request $request';
                                break;
                            case 'show':
                                el += '$id';
                                break;
                            case 'edit':
                                el += '$id';
                                break;
                            case 'update':
                                el += 'Request $request, $id';
                                break;
                            case 'destroy':
                                el += '$id';
                                break;
                            default:
                                if(method[0] != 'index' && method[0] != 'create') {
                                    method[1].forEach(param => {
                                        if(param.substring(param.length - 1, param.length) == '?') {
                                            param = param.substring(0, param.length - 1);
                                            el += param + " = null, ";
                                        } else {
                                            el += param + ', ';
                                        }
                                    });
                                    el = el.substring(0, el.length - 2);
                                }
                        }
                        el += ')\n' + tab + '{\n\n' + tab + '}\n\n';
                    });
                    el += '}';
                    this.texts.push(el);
                });
            },
            generateDoc(title, params) {
                const tab = '    ';
                let doc = tab + '/**\n';
                doc += tab + ' * ' + title + '\n';
                doc += tab + ' *\n';
                params.forEach(e => {
                    if(e.substring(e.length - 1, e.length) == '?') e = e.substring(0, e.length - 1);
                    doc += tab + ' * @param ' + e + '\n';
                });
                doc += tab + ' * @return \\Illuminate\\Http\\Response\n';
                doc += tab + ' */\n';
                return doc;
            }
        }
    }
</script>

<style scoped>

.collection .collection-item {
    line-height: 1rem;
}

</style>
