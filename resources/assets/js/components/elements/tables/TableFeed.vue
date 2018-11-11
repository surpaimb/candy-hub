<script>
export default {
  props: ['headings', 'items'],
  data() {
    return {
      rows: [],
    };
  },
  mounted() {
    this.rows = this.items;
  },
};
</script>

<template>
  <div>
    <table class="table table-striped product-table">
      <thead>
      <tr>
        <th>
          <div class="checkbox bulk-options">
            <input id="prodSelect1" type="checkbox" class="select-all">
            <label for="prodSelect1"><span class="check"></span></label>
            <i class="fa fa-caret-down" aria-hidden="true"></i>

            <div class="bulk-actions">
              <div class="border-inner">
                1 {{$t('forms.ProductSelected')}}
                <a href="#" class="btn btn-outline btn-sm">{{$t('forms.Edit')}}</a>
                <a href="#" class="btn btn-outline btn-sm">{{$t('forms.Publish')}}</a>
                <a href="#" class="btn btn-outline btn-sm">{{$t('forms.Hide')}}</a>
                <a href="#" class="btn btn-outline btn-sm">{{$t('forms.Delete')}}</a>
              </div>
              <div class="all-selected">
                <em>{{$t('forms.AllProductAreSelected')}}</em>
              </div>
            </div>
          </div>
        </th>
        <th v-for="h in headings">{{ h }}</th>
      </tr>
      </thead>
      <tbody>
      <tr></tr>
      </tbody>
    </table>
  </div>
</template>