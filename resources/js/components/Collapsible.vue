<template>
<div>
    <ul class="collapsible popout">
        <li v-for="(item, index) in items" :key="item.id">
            <div class="collapsible-header" :class="{'indigo lighten-5': item.type == 'group'}">
                <span v-if="item.type == 'group'" class="teal darken-3 white-text title">Group</span>
                <template v-else-if="item.type == 'route'">
                    <span class="teal darken-3 white-text title">Route</span>
                    <span class="teal lighten-2 white-text">{{ method(index) }}</span>&nbsp;
                    <span class="teal lighten-2 white-text">{{ item.url }}</span>
                </template>
                <template v-else-if="item.type == 'resource'">
                    <span class="teal darken-3 white-text title">Resource</span>&nbsp;
                    <span class="teal lighten-2 white-text">{{ item.url }}</span>&nbsp;
                    <span class="teal lighten-2 white-text">{{ item.controller }}</span>
                </template>
                <template v-else-if="item.type == 'view'">
                    <span class="teal darken-3 white-text title">View</span>
                    <span class="teal lighten-2 white-text">{{ item.url }}</span>&nbsp;
                    <span class="teal lighten-2 white-text">{{ item.name }}</span>
                </template>
                <template v-else-if="item.type == 'auth'">
                    <span class="teal darken-3 white-text title">Auth</span>
                    <span v-if="item.verify" class="teal lighten-2 white-text">Verify</span>
                </template>

                <i class="material-icons red-text tooltipped right" data-position="top" data-tooltip="Delete" @click.stop="del(null, index)">delete</i>
                <i v-if="index < items.length - 1" class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Down" @click.stop="down(null, index)">keyboard_arrow_down</i>
                <i v-if="index > 0" class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Up" @click.stop="up(null, index)">keyboard_arrow_up</i>
                <i class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Copy" @click.stop="copy(index)">content_copy</i>
                <i class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Cut" @click.stop="cut(null, index)">content_cut</i>
                <i class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Add after" @click.stop="addItem(null, index)">control_point</i>
                <i v-if="item.type == 'group'" class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Add inside" @click.stop="addInside(index, $event)">control_point_duplicate</i>
                <i class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Paste after" @click.stop="paste(null, index)">content_paste</i>
                <i style="font-size: 22px" v-if="item.type == 'group'" class="material-icons blue-text tooltipped right" data-position="top" data-tooltip="Paste inside" @click.stop="pasteInside(index)">content_paste</i>
                <i class="material-icons orange-text tooltipped right" data-position="top" data-tooltip="Edit" @click.stop="edit(index)">edit</i>
            </div>

            <div v-if="item.type != 'auth'" class="collapsible-body">
                <template v-if="item.type == 'group'">
                    <div class="bloc-infos">
                        <span v-if="item.namespace">Namespace:&nbsp;<span class="teal lighten-2 white-text">{{ item.namespace }}</span>&nbsp;</span>
                        <span v-if="item.prefix">Prefix:&nbsp;<span class="teal lighten-2 white-text">{{ item.prefix }}</span>&nbsp;</span>
                        <span v-if="item.domain">Domain:&nbsp;<span class="teal lighten-2 white-text">{{ item.domain }}</span>&nbsp;</span>
                        <span v-if="item.name">Name:&nbsp;<span class="teal lighten-2 white-text">{{ item.name }}</span>&nbsp;</span>
                        <span v-if="item.middlewares">Middlewares:&nbsp;<span class="teal lighten-2 white-text">{{ item.middlewares }}</span></span>
                    </div>
                </template>
                <template v-else-if="item.type == 'route'">
                    <span v-if="item.parameters && item.subType == 'closure'">Parameters:&nbsp;<span class="teal lighten-2 white-text">{{ item.parameters }}</span></span>
                    {{ item.subType == 'closure' ? 'Closure' : 'Method' }}:&nbsp;<span class="teal lighten-2 white-text">{{ item.content }}</span>&nbsp;
                    <span v-if="item.name">Name:&nbsp;<span class="teal lighten-2 white-text">{{ item.name }}</span>&nbsp;</span>
                    <span v-if="item.middlewares">Middlewares:&nbsp;<span class="teal lighten-2 white-text">{{ item.middlewares }}</span>&nbsp;</span>
                    <span v-if="item.where">Where:&nbsp;<span class="teal lighten-2 white-text">{{ item.where }}</span></span>
                </template>
                <template v-else-if="item.type == 'resource'">
                    <span v-if="item.index || item.create || item.store || item.show || item.edit || item.upadte || item.destroy">
                        {{ item.partial | capitalize }}:&nbsp;<span class="teal lighten-2 white-text">{{ partials(index) }}</span>&nbsp;
                    </span>
                    <span v-if="item.indexName || item.createName || item.storeName || item.showName || item.editName || item.upadteName || item.destroyName">
                        Routes names:&nbsp;<span class="teal lighten-2 white-text">{{ routesNames(index) }}</span>&nbsp;
                    </span>
                </template>
                <template v-else-if="item.type == 'view'">
                    <span v-if="item.parameters">Parameters:&nbsp;<span class="teal lighten-2 white-text">{{ item.parameters }}</span></span>
                </template>
                <collapsible
                    :items="item.items"
                    @copy="copy"
                    @paste="paste"
                    @edit="edit"
                    @cut="cut"
                    @del="del"
                    @addItem="addItem"
                    @down="down"
                    @up="up"
                ></collapsible>
            </div>
        </li>
    </ul>
</div>
</template>

<script>
    export default {
        data() {
            return {
                values: [],
                temp: []
            }
        },
        props: ['items'],
        methods: {
            sendCommand(command, items, index) {
                if(items != null) {
                    this.$emit(command, items, index);
                } else {
                    this.$emit(command, this.items, index);
                }
            },
            down(items, index) {
                this.sendCommand('down', items, index);
            },
            up(items, index) {
                this.sendCommand('up', items, index);
            },
            partial(index) {
                if(this.items[index].only) {
                    return 'Only';
                }
                return 'Except';
            },
            partials(index) {
                let e =  this.items[index];
                let result = '';
                if(e.index) result += 'index,';
                if(e.create) result += 'create,';
                if(e.store) result += 'store,';
                if(e.show) result += 'show,';
                if(e.edit) result += 'edit,';
                if(e.update) result += 'update,';
                if(e.destroy) result += 'destroy,';
                return result.slice(0, -1);
            },
            routesNames(index) {
                let e =  this.items[index];
                let result = '';
                if(e.indexName) result += e.indexName;
                result += ',';
                if(e.createName) result += e.createName;
                result += ',';
                if(e.storeName) result += e.storeName;
                result += ',';
                if(e.showName) result += e.showName;
                result += ',';
                if(e.editName) result += e.editName;
                result += ',';
                if(e.updateName) result += e.updateName;
                result += ',';
                if(e.destroyName) result += e.destroyName;
                return result.slice(0, -1);
            },
            method(index) {
                let e =  this.items[index];
                if(e.get && e.post && e.patch && e.put && e.delete && e.options) {
                    return 'any';
                } else {
                    let result = '';
                    if(e.get) result += 'get,';
                    if(e.post) result += 'post,';
                    if(e.put) result += 'put,';
                    if(e.patch) result += 'patch,';
                    if(e.delete) result += 'delete,';
                    if(e.options) result += 'options,';
                    return result.slice(0, -1);
                }
            },
            edit(index) {
                if(typeof(index) === 'object') {
                    this.$emit('edit', index);
                } else {
                    this.$emit('edit', this.items[index]);
                }
            },
            del(items, index) {
                this.sendCommand('del', items, index);
            },
            copy(index) {
                if(typeof(index) === 'object') {
                    this.$emit('copy', index);
                } else {
                    this.$emit('copy', this.items[index]);
                }
            },
            cut(items, index) {
                this.sendCommand('cut', items, index);
            },
            paste(items, index) {
                this.sendCommand('paste', items, index);
            },
            pasteInside(index) {
                this.$emit('paste', this.items[index].items, -1);
            },
            addItem(items, index) {
                this.sendCommand('addItem', items, index);
            },
            addInside(index, event) {
                $(event.target).closest('ul').collapsible('open', index);
                this.$emit('addItem', this.items[index].items, -1);
            }
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        },
        updated() {
            $('.tooltipped').tooltip();
        }
    }
</script>

<style scoped>
    .title, .teal {
        padding: 0 5px 5px;
        margin-right: 10px;
        margin-bottom: 5px;
    }
    .collapsible-header {
        display: block;
    }
    .collapsible-header i {
        width: .1rem;
    }
    .bloc-infos {
        margin-bottom: 20px;
    }
</style>

