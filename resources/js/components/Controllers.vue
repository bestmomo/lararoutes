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
                controllers: []
            }
        },
        methods: {
            reset() {
                this.controllers = [];
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
            loop(element) {
                element.forEach(e => {
                    let u = 0;
                    if(e.type == 'group') {
                        if(e.items) {
                            this.loop(e.items);
                        }
                    } else if(e.type == 'route' && e.subType == 'method') {
                        let controller = e.content.split('@')[0];
                        if(this.checkAbsent(controller)) {
                            this.controllers.push({'name': controller, 'functions': []});
                        }
                        let method = e.content.split('@')[1];
                        this.addMethod(controller, method);
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
                        if(f[0]) this.addMethod(controller, 'index');
                        if(f[2]) this.addMethod(controller, 'store');
                        if(f[1]) this.addMethod(controller, 'create');
                        if(f[3]) this.addMethod(controller, 'show');
                        if(f[5]) this.addMethod(controller, 'update');
                        if(f[6]) this.addMethod(controller, 'destroy');
                        if(f[4]) this.addMethod(controller, 'edit');
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
                        switch (method) {
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
                                el += this.generateDoc('Some elements there.', []);
                        }
                        el += tab + 'public function ' + method + '(';
                        switch (method) {
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
