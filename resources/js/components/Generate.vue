<template>
    <div>
        <button id="btn-copy" class="waves-effect waves-light btn right" @click="copyCode">Copy</button>
        <div id="code-generated" class="row">
            <div class="input-field col s12">
                <textarea id="to-copy" cols="80" rows="80">{{ text }}</textarea>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data () {
            return {
                text: '',
                tab: 0,
            }
        },
        computed: {
            tabs() {
                return ' '.repeat(this.tab);
            }
        },
        methods: {
            setArrow(arrow) {
                if(arrow) {
                    this.text += '->';
                    return false;
                }
                return true;
            },
            reset() {
                this.text = '';
            },
            loop(element) {
                element.forEach(e => {
                    if(e.type == 'group') {
                        this.text += this.tabs + 'Route::';
                        let arrow = false;
                        let el = false;
                        if(e.prefix) {
                            el = true;
                            if(this.setArrow(arrow)) arrow = true;
                            this.text += "prefix('" + e.prefix + "')";
                        }
                        if(e.name) {
                            el = true;
                            if(this.setArrow(arrow)) arrow = true;
                            this.text += "name('" + e.name + "')";
                        }
                        if(e.middlewares) {
                            el = true;
                            if(this.setArrow(arrow)) arrow = true;
                            this.text += "middleware(['" + e.middlewares.replace(",", "','") + "'])";
                        }
                        if(e.namespace) {
                            el = true;
                            if(this.setArrow(arrow)) arrow = true;
                            this.text += "namespace('" + e.namespace + "')";
                        }
                        if(e.domain) {
                            el = true;
                            if(this.setArrow(arrow)) arrow = true;
                            this.text += "domain('" + e.domain + "')";
                        }
                        if(el) {
                            this.text += '->';
                        }
                        this.text += 'group(function () {\n';
                        if(e.items) {
                            this.tab += 4;
                            this.loop(e.items);
                            this.tab -= 4;
                        }
                        this.text += this.tabs + '});\n';
                    } else if(e.type == 'route') {
                        this.text += this.tabs + 'Route::';
                        let arrow = false;
                        const l = [e.get, e.post, e.put, e.patch, e.delete, e.options].filter(Boolean).length;
                        if(l == 6) {
                            this.text += 'any(';
                        } else if (l > 1) {
                            let els = '';
                            if(e.get) {
                                els += "'get',";
                            }
                            if(e.post) {
                                els += "'post',";
                            }
                            if(e.put) {
                                els += "'put',";
                            }
                            if(e.patch) {
                                els += "'patch',";
                            }
                            if(e.delete) {
                                els += "'delete',";
                            }
                            if(e.options) {
                                els += "'options',";
                            }
                            this.text += 'match([' + els.slice(0, -1) + '],';
                        } else {
                            if(e.get) {
                                this.text += 'get(';
                            }
                            if(e.post) {
                                this.text += 'post(';
                            }
                            if(e.put) {
                                this.text += 'put(';
                            }
                            if(e.patch) {
                                this.text += 'patch(';
                            }
                            if(e.delete) {
                                this.text += 'delete(';
                            }
                            if(e.options) {
                                this.text += 'options(';
                            }
                        }
                        this.text += "'" + e.url + "', ";
                        if(e.subType == 'closure') {
                            this.text += 'function (';
                            if(e.parameters) {
                                this.text += e.parameters;
                            }
                            this.text += ') {\n    ' + this.tabs + e.content + '\n' + this.tabs + '})';
                        } else {
                            this.text += "'" + e.content + "')"
                        }
                        if(e.name) {
                            this.text += "->name('" + e.name + "')";
                        }
                        if(e.middlewares) {
                            this.text += "->middleware(['" + e.middlewares.replace(",", "','") + "'])";
                        }
                        if(e.where) {
                            this.text += '->where(' + e.where + ')';
                        }
                        this.text += ';\n';
                    } else if(e.type == 'resource') {
                        this.text += this.tabs + "Route::resource('" + e.url + "', '" + e.controller + "')";
                        if(e.index || e.create || e.store || e.show || e.edit || e.update || e.destroy) {
                            if(e.partial == 'only') {
                                this.text += '->only([ \n    ' + this.tabs;
                            } else {
                                this.text += '->except([ \n    ' + this.tabs;
                            }
                            if(e.index) {
                                this.text += "'index',";
                            }
                            if(e.create) {
                                this.text += "'create',";
                            }
                            if(e.store) {
                                this.text += "'store',";
                            }
                            if(e.show) {
                                this.text += "'show',";
                            }
                            if(e.edit) {
                                this.text += "'edit',";
                            }
                            if(e.update) {
                                this.text += "'update',";
                            }
                            if(e.destroy) {
                                this.text += "'destroy',";
                            }
                            this.text = this.text.slice(0, -1);
                            this.text += '\n' + this.tabs + '])';
                        }
                        if(e.indexName || e.createName || e.storeName || e.showName || e.editName || e.updateName || e.destroyName) {
                            this.text += '->names([';
                            if(e.indexName) {
                                this.text += '\n' + this.tabs + "    'index' => '" + e.indexName + "',";
                            }
                            if(e.createName) {
                                this.text += '\n' + this.tabs + "    'create' => '" + e.createName + "',";
                            }
                            if(e.storeName) {
                                this.text += '\n' + this.tabs + "    'store' => '" + e.storeName + "',";
                            }
                            if(e.showName) {
                                this.text += '\n' + this.tabs + "    'show' => '" + e.showName + "',";
                            }
                            if(e.editName) {
                                this.text += '\n' + this.tabs + "    'edit' => '" + e.editName + "',";
                            }
                            if(e.updateName) {
                                this.text += '\n' + this.tabs + "    'update' => '" + e.updateName + "',";
                            }
                            if(e.destroyName) {
                                this.text += '\n' + this.tabs + "    'destroy' => '" + e.destroyName + "',";
                            }
                            this.text = this.text.slice(0, -1);
                            this.text += '\n' + this.tabs + '])';
                        }
                        this.text += ';\n';
                    } else if(e.type == 'view') {
                        this.text += this.tabs + "Route::view('" + e.url + "', '" + e.view + "'";
                        if(e.parameters) {
                            this.text += ", [" + e.parameters + ']';
                        }
                        this.text += ')';
                        if(e.name) {
                            this.text += "->name('" + e.name + "')";
                        }
                        if(e.middlewares) {
                            this.text += "->middleware(['" + e.middlewares.replace(",", "','") + "'])";
                        }
                        this.text += ';\n';
                    } else if(e.type == 'auth') {
                        this.text += this.tabs + 'Auth::routes(';
                        if(e.verify) {
                            this.text += "['verify' => true]";
                        }
                        this.text += ');\n';
                    }
                })
            },
            copyCode() {
                $('#to-copy').select();
	            document.execCommand('copy');
            }
        }
    }
</script>

