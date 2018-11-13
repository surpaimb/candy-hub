<script>
import EditableTable from './../../elements/tables/Editable.vue';

export default {
  data() {
    return {
      attribute: {},
      loaded: false,
      translating: false,
      groups: [],
      translationLanguage: locale.current(),
      languages: [],
      changeGroup: false,
      fields: {},
      params: {
        includes: 'group',
      },
    };
  },
  props: ['id'],
  components: {
    'editable-table': EditableTable,
  },
  mounted() {
    this.loadLanguages();
    this.loadGroups();
    this.load();
  },
  methods: {
    save() {
      console.log('Comming Soon');
    },
    load() {
      apiRequest
        .send('get', '/attributes/' + this.id, [], this.params)
        .then(response => {
          this.attribute = response.data;
          this.attribute.group_id = this.attribute.group.data.id;
          this.fields['name'] = {
            value: this.attribute.name,
            type: 'text',
            translatable: true,
          };
          this.loaded = true;
          document.title =
            this.attribute.name[this.translationLanguage] + ' Attribute - Edit';
          CandyEvent.$emit('title-changed', {
            title: this.attribute.name[this.translationLanguage],
          });
        });
    },
    loadGroups() {
      apiRequest.send('get', 'attribute-groups', [], []).then(response => {
        this.groups = response.data;
      });
    },
    viewGroup(id) {
      return route('hub.attribute-groups.edit', id);
    },
    loadLanguages() {
      apiRequest.send('get', 'languages', [], []).then(response => {
        response.data.forEach(lang => {
          this.languages.push({
            label: lang.name,
            value: lang.lang,
            content:
              "<span class='flag-icon flag-icon-" +
              lang.iso +
              "'></span> " +
              lang.name,
          });
        });
      });
    },
  },
};
</script>

<template>
    <div>
        <template v-if="loaded">

            <transition name="fade">
                <candy-tabs initial="attributedetails">
                    <candy-tab :name="$t('attribute.AttributeDetails')" handle="attribute-details" :selected="true">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <template v-if="attribute.system">
                                            <div class="alert alert-warning">
                                                {{$t('attribute.editAttributePrompt')}}
                                            </div>
                                        </template>
                                        <div class="col-xs-12 text-right">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <div v-show="translating">
                                                        <label class="sr-only">{{$t('attribute.Language')}}</label>
                                                        <candy-select :options="languages" v-model="translationLanguage" v-if="languages.length"></candy-select>
                                                    </div>
                                                </div>
                                                <button v-if="!translating" class="btn btn-default" @click="translating = true">{{$t('attribute.Translate')}}</button>
                                                <button v-if="translating" class="btn btn-default" @click="translating = false">{{$t('attribute.HideTranslation')}}</button>
                                            </div>

                                        </div>
                                        <candy-option-translatable :fields="fields"
                                            :params="{'translating':translating, 'language':translationLanguage}">
                                        </candy-option-translatable>
                                        <div class="form-group">
                                            <label>{{$t('attribute.handle')}}</label>
                                            <input class="form-control" v-model="attribute.handle" :readonly="attribute.system">
                                        </div>
                                        <div class="form-group">
                                            <label>{{$t('attribute.Type')}}</label>
                                            <select class="form-control" v-model="attribute.type" :disabled="attribute.system">
                                                <option value="text">{{$t('attribute.Text')}}</option>
                                                <option value="richtext">{{$t('attribute.Richtext')}}</option>
                                                <option value="select">{{$t('attribute.Select')}}</option>
                                            </select>
                                        </div>
                                        <template v-if="attribute.type == 'select'">
                                            <div class="form-group">
                                                <label>{{$t('attribute.Lookups')}}</label>
                                                <editable-table></editable-table>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="col-md-4">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>{{$t('attribute.Settings')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><label for="searchable">{{$t('attribute.Searchable')}}</label></td>
                                                    <td><input type="checkbox" v-model="attribute.searchable" id="searchable" :disabled="attribute.system"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="filterable">{{$t('attribute.Filterable')}}</label></td>
                                                    <td><input type="checkbox" v-model="attribute.filterable" id="filterable" :disabled="attribute.system"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="required">{{$t('attribute.Required')}}</label></td>
                                                    <td><input type="checkbox" v-model="attribute.required" id="required" :disabled="attribute.system"></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="required">{{$t('attribute.Translatable')}}</label></td>
                                                    <td><input type="checkbox" v-model="attribute.translatable" id="required" :disabled="attribute.system"></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td><label for="channeled">Channeled</label></td>
                                                    <td><input type="checkbox" v-model="attribute.channeled" id="channeled"></td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <label>
                                                {{$t('attribute.AttributeGroup')}}
                                            </label>
                                            <template v-if="!changeGroup">
                                                <br><strong>{{ attribute.group.data.name|t }} </strong>   &middot; <a href="" @click.prevent="changeGroup = true">{{$t('attribute.change')}}</a> / <a :href="viewGroup(attribute.group_id)">{{$t('attribute.view')}}</a>
                                            </template>
                                            <select class="form-control" v-model="attribute.group_id" v-if="changeGroup" @change="changeGroup = false">
                                                <option v-for="group in groups" :value="group.id">
                                                    {{ group.name['en'] }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </candy-tab>
                </candy-tabs>
            </transition>
        </template>

        <div v-else>
            <div class="page-loading loading">
                <span><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></span> <strong>Loading</strong>
            </div>
        </div>

    </div>

</template>