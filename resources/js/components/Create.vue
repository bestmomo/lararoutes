<template>
    <div>
        <br>
        <div id="edit-group" class="modal">
            <div class="modal-content">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.middlewares" id="middlewares" name="middlewares" type="text" autofocus>
                                <label for="middlewares">Middlewares</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.prefix" id="prefix" name="prefix" type="text">
                                <label for="prefix">Prefix</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.name" id="name" name="name" type="text">
                                <label for="name">Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.domain" id="domain" name="domain" type="text">
                                <label for="domain">Domain</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input v-model="values.namespace" id="namespace" name="namespace" type="text">
                                <label for="namespace">Namespace</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div id="edit-route" class="modal">
            <div class="modal-content">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <p class="col s2">
                                <label>
                                    <input type="checkbox" v-model="values.get">
                                    <span>Get</span>
                                </label>
                            </p>
                            <p class="col s2">
                                <label>
                                    <input type="checkbox" v-model="values.post">
                                    <span>Post</span>
                                </label>
                            </p>
                            <p class="col s2">
                                <label>
                                    <input type="checkbox" v-model="values.put">
                                    <span>Put</span>
                                </label>
                            </p>
                            <p class="col s2">
                                <label>
                                    <input type="checkbox" v-model="values.patch">
                                    <span>Patch</span>
                                </label>
                            </p>
                            <p class="col s2">
                                <label>
                                    <input type="checkbox" v-model="values.delete">
                                    <span>Delete</span>
                                </label>
                            </p>
                            <p class="col s2">
                                <label>
                                    <input type="checkbox" v-model="values.options">
                                    <span>Options</span>
                                </label>
                            </p>
                        </div>
                        <div class="row">
                            <p class="col s6">
                                <label>
                                    <input type="radio" value="closure" v-model="values.subType">
                                    <span>Closure</span>
                                </label>
                            </p>
                            <p class="col s6">
                                <label>
                                    <input type="radio" value="method" v-model="values.subType">
                                    <span>Method</span>
                                </label>
                            </p>
                        </div>
                        <div class="row">
                            <div class="input-field col s6" v-if="values.subType == 'closure'">
                                <input v-model="values.parameters" id="parameters" name="parameters" type="text">
                                <label for="parameters">Parameters</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.url" id="url" name="url" type="text">
                                <label for="url">Url</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.content" id="content" name="content" type="text" autofocus>
                                <label for="content">{{ values.subType == 'closure' ? 'Closure' : 'Method'}}</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.name" id="name1" name="name" type="text">
                                <label for="name1">Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.middlewares" id="middlewares1" name="middlewares" type="text">
                                <label for="middlewares1">Middlewares</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.where" id="where" name="where" type="text" placeholder="['id' => '[0-9]+']">
                                <label for="where">Where</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div id="edit-resource" class="modal">
            <div class="modal-content">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.url" id="url1" name="url" type="text">
                                <label for="url1">Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.controller" id="controller" name="controller" type="text">
                                <label for="controller">Controller</label>
                            </div>
                        </div>
                        <div class="row bordered">
                            Partials
                            <div class="row bordered">
                                <p class="col s6">
                                    <label>
                                        <input name="partial" type="radio" value="only" v-model="values.partial">
                                        <span>Only</span>
                                    </label>
                                </p>
                                <p class="col s6">
                                    <label>
                                        <input name="partial" type="radio" value="except" v-model="values.partial">
                                        <span>Except</span>
                                    </label>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.index">
                                        <span>Index</span>
                                    </label>
                                </p>
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.create">
                                        <span>Create</span>
                                    </label>
                                </p>
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.store">
                                        <span>Store</span>
                                    </label>
                                </p>
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.show">
                                        <span>Show</span>
                                    </label>
                                </p>
                            </div>
                            <div class="row">
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.edit">
                                        <span>Edit</span>
                                    </label>
                                </p>
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.update">
                                        <span>Update</span>
                                    </label>
                                </p>
                                <p class="col s3">
                                    <label>
                                        <input type="checkbox" v-model="values.destroy">
                                        <span>Destroy</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="row bordered">
                            Routes names
                            <div class="row">
                                <div class="input-field col s3">
                                    <input v-model="values.indexName" id="indexName" name="indexName" type="text">
                                    <label for="indexName">Index</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="values.createName" id="createName" name="createName" type="text">
                                    <label for="createName">Create</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="values.storeName" id="storeName" name="storeName" type="text">
                                    <label for="storeName">Store</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="values.showName" id="showName" name="showName" type="text">
                                    <label for="showName">Show</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s3">
                                    <input v-model="values.editName" id="editName" name="editName" type="text">
                                    <label for="editName">Edit</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="values.updateName" id="updateName" name="updateName" type="text">
                                    <label for="updateName">Update</label>
                                </div>
                                <div class="input-field col s3">
                                    <input v-model="values.destroyName" id="destroyName" name="destroyName" type="text">
                                    <label for="destroyName">destroy</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div id="edit-view" class="modal">
            <div class="modal-content">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.url" id="viewUrl" name="viewUrl" type="text" autofocus>
                                <label for="viewUrl">Url</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.view" id="view" name="view" type="text">
                                <label for="view">View</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input v-model="values.parameters" id="viewParameters" name="viewParameters" type="text" placeholder="['key' => 'value']">
                                <label for="viewParameters">Parameters</label>
                            </div>
                            <div class="input-field col s6">
                                <input v-model="values.name" id="viewName" name="viewName" type="text">
                                <label for="viewName">Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input v-model="values.middlewares" id="viewMiddlewares" name="viewMiddlewares" type="text">
                                <label for="viewMiddlewares">Middlewares</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div id="edit-auth" class="modal">
            <div class="modal-content">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <label>
                                <input type="checkbox" v-model="values.verify">
                                <span>Verify</span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div id="generate" class="modal">
            <generate :items="items" ref="generator"></generate>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div id="list" class="modal bottom-sheet">
            <list :items="items" ref="list"></list>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <div class="row">
            <div v-if="auth" class="input-field col s6">
                <input v-model="routeName" id="routename" name="routename" type="text">
                <label for="routename">Name</label>
            </div>
            <div class="input-field col s6">
                <a v-if="auth" class="waves-effect waves-light btn" @click="saveRoute()">Save</a>
                <a class="waves-effect waves-light btn" @click="generate()">Generate</a>
                <a class="waves-effect waves-light btn" @click="list()">List</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <a class="waves-effect waves-light btn" @click="addItem(items, -1)">Add</a>
            <label>
                <input name="add" type="radio" value="resource" v-model="add">
                <span>Resource</span>
            </label>
            <label>
                <input name="add" type="radio" value="group" v-model="add">
                <span>Group</span>
            </label>
            <label>
                <input name="add" type="radio" value="route" v-model="add">
                <span>Route</span>
            </label>
            <label>
                <input name="add" type="radio" value="view" v-model="add">
                <span>View</span>
            </label>
            <label>
                <input name="add" type="radio" value="auth" v-model="add">
                <span>Auth</span>
            </label>
        </div>
        <hr>

        <collapsible
            :items="items"
            @copy="copy"
            @paste="paste"
            @edit="edit"
            @cut="cut"
            @del="del"
            @addItem="addItem"
            @down="down"
            @up="up"
        ></collapsible>

        <footer v-if="!auth" class="page-footer" style="padding-top:0; margin-top:50px">
            <div class="footer-copyright">
                <div class="container center">
                    <p class="grey-text text-lighten-4">You must register to save and manage your creations</p>
                </div>
            </div>
        </footer>

    </div>
</template>

<script>
    $(document).ready(function(){
        $('.collapsible').collapsible();
        $('.tooltipped').tooltip();
    });

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    window.addEventListener("beforeunload", function (event) {
        if(!saved) {
            event.preventDefault();
            event.returnValue = 'Are you sure ?';
        }
    });

    let saved = true;

    export default {
        props: ['data', 'name', 'id', 'auth'],
        data () {
            return {
                text: '',
                tab: 0,
                add: 'resource',
                clipboard: {},
                cutIndex: -1,
                tempItems: {},
                values: {},
                routeName: '',
                items:[]
            }
        },
        computed: {
            tabs() {
                return ' '.repeat(this.tab);
            }
        },
        methods: {
            down(items, index) {console.log(items)
                this.cut(items, index, true);
                this.paste(items, index);
                $('.tooltipped').tooltip('close');
            },
            up(items, index) {
                this.cut(items, index, true);
                this.paste(items, index - 2);
                $('.tooltipped').tooltip('close');
            },
            saveRoute() {
                if(this.id == -1) {
                    $.post('/routes', {
                            name: this.routeName,
                            route: JSON.stringify(this.items)
                        })
                        .done(function(data) {
                            M.toast({html: 'Saved !', classes: 'rounded'});
                            saved = true;
                        }).fail(function(data) {
                            M.toast({html: data.responseJSON.errors.name, classes: 'rounded'});
                        });
                } else {
                    $.ajax({
                            url: '/routes/' + this.id,
                            method: 'PUT',
                            data: { name: this.routeName, route: JSON.stringify(this.items) }
                        })
                        .done(function(data) {
                            M.toast({html: 'Updated !', classes: 'rounded'});
                            saved = true;
                        }).fail(function(data) {
                            M.toast({html: data.responseJSON.errors.name, classes: 'rounded'});
                        });
                }
            },
            addItem(items, index) {
                let newItem = {};
                if(this.add == 'resource') {
                    newItem = {
                        id: uuid(),
                        url: 'name',
                        controller: 'Controller',
                        type: 'resource',
                        partial: 'only',
                        index: false,
                        create: false,
                        store: false,
                        show: false,
                        edit: false,
                        update: false,
                        destroy: false,
                        indexName: '',
                        createName: '',
                        storeName: '',
                        showName: '',
                        editName: '',
                        updateName: '',
                        destroyName: ''
                    };
                } else if(this.add == 'group') {
                    newItem = {
                        id: uuid(),
                        type: 'group',
                        middlewares: '',
                        namespace: '',
                        prefix: '',
                        domain: '',
                        name: '',
                        items: []
                    };
                } else if(this.add == 'route') {
                    newItem = {
                        id: uuid(),
                        url: 'foo',
                        type: 'route',
                        subType: 'method',
                        content: 'mycontroller@method',
                        name: '',
                        get: true,
                        post: false,
                        patch:false,
                        put: false,
                        delete: false,
                        options: false,
                        where: '',
                        middlewares: '',
                        parameters: ''
                    };
                } else if(this.add == 'view') {
                    newItem = {
                        id: uuid(),
                        view: 'welcome',
                        name: '',
                        url: 'url',
                        type: 'view',
                        middlewares: '',
                        parameters: ''
                    }
                } else if(this.add == 'auth') {
                    newItem = {
                        id: uuid(),
                        type: 'auth',
                        verify: false
                    }
                }
                items.splice(index + 1, 0, newItem);
            },
            edit(values) {
                this.values = values;
                $('#edit-' + values.type).modal('open');
            },
            generate() {
                this.$refs.generator.reset();
                this.$refs.generator.loop(this.items);
                $('#generate').modal('open');
            },
            list() {
                this.$refs.list.reset();
                this.$refs.list.loop(this.items);
                $('#list').modal('open');
            },
            paste(items, index) {
                if(!$.isEmptyObject(this.clipboard)) {
                    let temp = JSON.parse(JSON.stringify(this.clipboard), (key, value) => {
                        if (key == 'id') {
                            return uuid();
                        }
                        return value;
                    });
                    if(this.cutIndex != -1) {
                        this.tempItems = this.tempItems.splice(this.cutIndex, 1);
                    }
                    items.splice(index + 1, 0, temp);
                }
            },
            copy(values) {
                this.clipboard = values;
                this.cutIndex = -1;
                M.toast({html: 'Element copied'});
            },
            cut(items, index, move = false) {
                this.clipboard = items[index];
                this.tempItems = items;
                this.cutIndex = index;
                if(!move) M.toast({html: 'Element cuted'});
            },
            del(items, index) {console.log(index)
                items = items.splice(index, 1);
                $('.tooltipped').tooltip('close');
            }
        },
        updated: function () {
            this.$nextTick(function () {
                $('.collapsible').collapsible();
                saved = false;
            });
            M.updateTextFields();
        },
        mounted() {
            this.items = JSON.parse(JSON.stringify(this.data));
            this.routeName = this.name;
            $('.modal').modal();
            $('select').formSelect();
        }
    }
</script>

<style scoped>

    .bordered {
        border: 1px solid;
        border-radius: 5px;
        padding: 20px;
    }
    hr {
        margin: 15px 0 20px;
    }
    .btn {
        margin-right: 10px;
    }

</style>

