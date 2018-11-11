<script>
export default {
  data() {
    return {
      request: apiRequest,
      saveModalOpen: false,
      redirectToDelete: {},
      deleteModalOpen: false,
      newUrl: {
        locale: 'en',
        redirect: true,
        description: '',
        slug: '',
      },
      redirects: [],
    };
  },
  computed: {
    slugify: {
      get() {
        return this.newUrl.slug.slugify(true);
      },
      set() {
        return this.newUrl.slug.slugify(true);
      },
    },
  },
  props: {
    product: {
      type: Object,
    },
    routes: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  mounted() {
    this.routes.forEach(route => {
      if (route.redirect) {
        this.redirects.push(route);
      }
    });
  },
  methods: {
    saveRedirect() {
      let data = this.newUrl;
      data.slug = data.slug.slugify(true);
      this.request
        .send('post', '/products/' + this.product.id + '/redirects', data)
        .then(response => {
          CandyEvent.$emit('notification', {
            level: 'success',
          });
          this.redirects.push({
            slug: data.slug,
            description: data.description,
            locale: data.locale,
          });
          this.newUrl = {};
          this.saveModalOpen = false;
        });
    },
    deleteRedirect() {
      this.request
        .send('delete', '/routes/' + this.redirectToDelete.id)
        .then(response => {
          CandyEvent.$emit('notification', {
            level: 'success',
          });
          this.redirects.splice(this.deletedIndex, 1);

          this.redirectToDelete = {};
          this.deletedIndex = null;
          this.deleteModalOpen = false;
        });
    },
    showDeleteModal(index) {
      this.deletedIndex = index;
      this.redirectToDelete = this.redirects[index];
      this.deleteModalOpen = true;
    },
    closeDeleteModal() {
      this.request.clearError();
      this.deleteModalOpen = false;
    },
  },
};
</script>

<template>
   <div>
       <div class="row">
          <div class="col-xs-12 col-md-11">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <h4>{{$t('product.RedirectURLs')}}</h4>
              </div>
              <div class="col-xs-12 col-sm-6 text-right">
                <button type="button" class="btn btn-primary" @click="saveModalOpen = true">{{$t('product.AddRedirect')}}</button>
              </div>
            </div>
            <hr>
            <table class="table">
              <thead>
                <tr>
                  <td width="30%">{{$t('product.RedirectURL')}}</td>
                  <td>{{$t('product.Description')}}</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(redirect, index) in redirects">
                  <td><input type="text" class="form-control" :value="redirect.slug"></td>
                  <td>
                    {{ redirect.description }}
                  </td>
                  <td align="right">
                      <button class="btn btn-sm btn-default btn-action"  @click="showDeleteModal(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </td>
                </tr>
              </tbody>
              <tfoot v-if="!redirects.length">
                <tr>
                  <td colspan="2">
                    <span class="text-muted">{{$t('product.CurrentlyNoRedirects')}}</span>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
       <candy-modal :title="$t('product.DeleteRoute')" v-show="deleteModalOpen" @closed="closeDeleteModal">
           <div slot="body">
               <p>{{$t('product.NotUndo')}}</p>
               <div class="form-group">
                   <input type="text" class="form-control" :value="redirectToDelete.slug" disabled>
                   <span class="text-danger" v-if="request.getError()" v-text="request.getError()"></span>
                   <!-- Dynamically add corresponding URL -->
               </div>
           </div>
           <template slot="footer">
               <button type="button" class="btn btn-primary" @click="deleteRedirect">{{$t('product.ConfirmDeletion')}}</button>
           </template>
       </candy-modal>
       <candy-modal title="Add redirect" v-show="saveModalOpen" @closed="saveModalOpen = false">
           <div slot="body">
               <div class="form-group">
                   <label for="redirectURL">{{$t('product.EnterURLWish')}}</label>
                   <input type="text" class="form-control" v-model="newUrl.slug" @input="request.clearError('url')">
                   <span class="text-info" v-if="newUrl.slug && slugify != newUrl.slug">{{$t('product.urlPrompt')}}: <code>{{ slugify }}</code></span>
                   <span class="text-danger" v-if="request.getError('slug')" v-text="request.getError('slug')"></span>
               </div>
               <div class="form-group">
                   <label for="explaination">{{$t('product.BriefRdirect')}}</label>
                   <textarea id="explaination" class="form-control" v-model="newUrl.description"></textarea>
               </div>
           </div>
           <template slot="footer">
               <button class="btn btn-primary" @click="saveRedirect()">{{$t('product.SaveRedirect')}}</button>
           </template>
       </candy-modal>
   </div>
</template>