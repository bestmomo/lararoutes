<template>
    <div>
      <table class="striped">
        <thead>
          <tr>
              <th>Domain</th>
              <th>Method</th>
              <th>URI</th>
              <th>Name</th>
              <th>Action</th>
              <th>Middlewares</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(line, index) in lines" :key="line.id">
            <td>{{ line.domain }}</td>
            <td>{{ line.method }}</td>
            <td>{{ line.uri }}</td>
            <td>{{ line.name }}</td>
            <td>{{ line.action }}</td>
            <td>{{ line.middlewares }}</td>
          </tr>
        </tbody>
      </table>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data () {
            return {
                lines: [],
                prefix: [],
                domain: [],
                middlewares: [],
                name: [],
                namespace: []
            }
        },
        methods: {
            reset() {
                this.lines = [];
            },
            setPrefix(prefix) {
                return this.setElement(this.prefix, prefix, '/');
            },
            setNamespace(namespace) {
                return '...\Http\Controllers\\' + this.setElement(this.namespace, namespace, '\\');
            },
            setName(name) {
                return this.setElement(this.name, name, '.');
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
            setMiddlewares(middlewares) {
                //let ar = this.middlewares.slice(0);
                let s = this.middlewares.filter(Boolean).join();
                if(middlewares != '') s += middlewares;
                return s;
            },
            loop(element) {
                element.forEach(e => {
                    if(e.type == 'group') {
                        this.prefix.push(e.prefix);
                        this.name.push(e.name);
                        this.middlewares.push(e.middlewares);
                        this.namespace.push(e.namespace);
                        this.domain.push(e.domain);
                        if(e.items) {
                            this.loop(e.items);
                        }
                        this.prefix.pop();
                        this.name.pop();
                        this.middlewares.pop();
                        this.namespace.pop();
                        this.domain.pop();
                    } else if(e.type == 'route') {
                        let el = {};
                        const l = [e.get, e.post, e.put, e.patch, e.delete, e.options].filter(Boolean).length;
                        if(l == 6) {
                            el.method =  'any';
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
                            el.method = els.slice(0, -1);
                        } else {
                            if(e.get) {
                                el.method = 'get';
                            }
                            if(e.post) {
                                el.method = 'post';
                            }
                            if(e.put) {
                                el.method = 'put';
                            }
                            if(e.patch) {
                                el.method = 'patch';
                            }
                            if(e.delete) {
                                el.method = 'delete';
                            }
                            if(e.options) {
                                el.method = 'options';
                            }
                        }
                        el.uri = this.setPrefix(e.url);
                        if(e.subType == 'closure') {
                            el.action = 'Closure';
                        } else {
                            el.action = this.setNamespace(e.content);
                        }
                        el.name = this.setName(e.name);
                        el.middlewares = this.setMiddlewares(e.middlewares);
                        this.lines.push(el);
                    } else if(e.type == 'resource') {
                        let f = [1,1,1,1,1,1,1];
                        let el = {};
                        let controller = e.controller;
                        let singular = pluralize.singular(e.url);
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
                        if(f[0]){
                            el = {};
                            el.method = 'get';
                            el.uri = this.setPrefix(e.url);
                            if(e.indexName) el.name = this.setName(e.indexName);
                            else el.name = this.setName(e.url) + '.index';
                            el.action = this.setNamespace(controller) + '@index';
                            this.lines.push(el);
                        }
                        if(f[2]){
                            el = {};
                            el.method = 'post';
                            el.uri = this.setPrefix(e.url);
                            if(e.storeName) el.name = this.setName(e.storeName);
                            else el.name = this.setName(e.url) + '.store';
                            el.action = this.setNamespace(controller) + '@store';
                            this.lines.push(el);
                        }
                        if(f[1]){
                            el = {};
                            el.method = 'get';
                            el.uri = this.setPrefix(e.url) + '/create';
                            if(e.createName) el.name = this.setName(e.createName);
                            else el.name = this.setName(e.url) + '.create';
                            el.action = this.setNamespace(controller) + '@create';
                            this.lines.push(el);
                        }
                        if(f[3]){
                            el = {};
                            el.method = 'get';
                            el.uri = this.setPrefix(e.url) + '/{' + singular + '}';
                            if(e.showName) el.name = this.setName(e.showName);
                            else el.name = this.setName(e.url) + '.show';
                            el.action = this.setNamespace(controller) + '@show';
                            this.lines.push(el);
                        }
                        if(f[5]){
                            el = {};
                            el.method = 'put';
                            el.uri = this.setPrefix(e.url) + '/{' + singular + '}';
                            if(e.updateName) el.name = this.setName(e.updateName);
                            else el.name = this.setName(e.url) + '.update';
                            el.action = this.setNamespace(controller) + '@update';
                            this.lines.push(el);
                        }
                        if(f[6]){
                            el = {};
                            el.method = 'delete';
                            el.uri = this.setPrefix(e.url) + '/{' + singular + '}';
                            if(e.destroyName) el.name = this.setName(e.destroyName);
                            else el.name = this.setName(e.url) + '.destroy';
                            el.action = this.setNamespace(controller) + '@destroy';
                            this.lines.push(el);
                        }
                        if(f[4]){
                            el = {};
                            el.method = 'get';
                            el.uri = this.setPrefix(e.url) + '/{' + singular + '}/edit';
                            if(e.editName) el.name = this.setName(e.editName);
                            else el.name = this.setName(e.url) + '.edit';
                            el.action = this.setNamespace(controller) + '@edit';
                            this.lines.push(el);
                        }
                    } else if(e.type == 'view') {
                        let el = {};
                        el.uri = this.setPrefix(e.url);
                        el.action = 'Illuminate\Routing\ViewController';
                        el.name = this.setName(e.name);
                        el.middlewares = this.setMiddlewares(e.middlewares);
                        this.lines.push(el);
                    } else if(e.type == 'auth') {
                        let el = {};
                        el.method = 'get';
                        el.uri = this.setPrefix('login');
                        el.name = this.setName('login');
                        el.action = '...\Auth\LoginController@showLoginForm';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'post';
                        el.uri = this.setPrefix('login');
                        el.name = '';
                        el.action = '...\Auth\LoginController@login';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'get';
                        el.uri = this.setPrefix('register');
                        el.name = this.setName('register');
                        el.action = '...\Auth\RegisterController@showRegistrationForm';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'post';
                        el.uri = this.setPrefix('register');
                        el.name = '';
                        el.action = '...\Auth\RegisterController@register';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'post';
                        el.uri = this.setPrefix('logout');
                        el.name = this.setName('logout');
                        el.action = '...\Auth\RegisterController@logout';
                        el.middlewares = this.setMiddlewares('');
                        this.lines.push(el);
                        el = {};
                        el.method = 'post';
                        el.uri = this.setPrefix('password/email');
                        el.name = this.setName('password.email');
                        el.action = '...\Auth\ForgotPasswordController@sendResetLinkEmail';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'get';
                        el.uri = this.setPrefix('password/reset');
                        el.name = this.setName('password.request');
                        el.action = '...\Auth\ForgotPasswordController@showLinkRequestForm';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'post';
                        el.uri = this.setPrefix('password/reset');
                        el.name = this.setName('password.update');
                        el.action = '...\Auth\ResetPasswordController@reset';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                        el = {};
                        el.method = 'get';
                        el.uri = this.setPrefix('password/reset/{token}');
                        el.name = this.setName('password.reset');
                        el.action = '...\Auth\ResetPasswordController@showResetForm';
                        el.middlewares = this.setMiddlewares('guest');
                        this.lines.push(el);
                    }
                })
            }
        }
    }
</script>

<style scoped>
    td {
        padding: 0;
    }
</style>
