<script>
    export default {
        data() {
            return {
                modal: false,
                groups: [],
                request: apiRequest,
                attribute: this.base()
            }
        },
        mounted() {
            this.request.send('get', '/attribute-groups').then(response => {
                this.groups = response.data;
                this.attribute.group_id = this.groups[0].id;
            });
        },
        computed: {
            name: {
                get() {
                    return this.attribute.name[locale.current()];
                },
                set(value) {
                    this.attribute.name[locale.current()] = value;
                }
            }
        },
        watch: {
            name() {
                if (!this.customHandle) {
                    this.attribute.handle = this.attribute.name[locale.current()].slugify('_');
                }
            }
        },
        methods: {
            base() {
                return {
                    name: {
                        [locale.current()] : ''
                    },
                    handle: '',
                    type: 'text',
                    group_id: ''
                };
            },
            save() {
                this.request.send('post', '/attributes', this.attribute)
                .then(response => {
                    CandyEvent.$emit('notification', {
                        level: 'success'
                    });
                    this.modal = false;
                    this.attribute = this.base();
                    CandyEvent.$emit('attribute-added', response.data);
                }).catch(response => {
                    CandyEvent.$emit('notification', {
                        level: 'error',
                        message: 'Missing / Invalid fields'
                    });
                });
            }
        }
    }
</script>

<template>
    <div>
        <button class="btn btn-success" @click="modal = true"><i class="fa fa-plus fa-first" aria-hidden="true"></i> {{$t('attribute.CreateAttribute')}}</button>
        <candy-modal title="Create Attribute" v-show="modal" size="modal-md" @closed="modal = false">
            <div slot="body">
                <div class="form-group">
                    <label>{{$t('attribute.name')}}</label>
                    <input class="form-control" v-model="name">
                </div>
                <div class="form-group">
                    <label>{{$t('attribute.handle')}}</label>
                    <input class="form-control" v-model="attribute.handle" @keyup="customHandle = true">
                    <span class="text-danger" v-if="request.getError('handle')" v-text="request.getError('handle')"></span>
                </div>
                <div class="form-group">
                    <label>{{$t('attribute.name')}}Type</label>
                    <select class="form-control" v-model="attribute.type">
                        <option value="text">{{$t('attribute.Text')}}</option>
                        <option value="select">{{$t('attribute.Select')}}</option>
                        <option value="richtext">{{$t('attribute.Richtext')}}</option>
                        <option value="checkbox">{{$t('attribute.Checkbox')}}</option>
                        <option value="radio">{{$t('attribute.Radio')}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>{{$t('attribute.Group')}}</label>
                    <select class="form-control" v-model="attribute.group_id">
                        <option v-for="group in groups" :value="group.id">{{ group.name|t }}</option>
                    </select>
                </div>
            </div>
            <template slot="footer">
                <button type="button" class="btn btn-primary" @click="save">{{$t('attribute.CreateAttribute')}}</button>
            </template>
        </candy-modal>
    </div>
</template>