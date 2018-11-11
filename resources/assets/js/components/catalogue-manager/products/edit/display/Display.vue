<template>
  <div class="sub-panel">
    <div class="sub-content section block">
      <h4>{{$t('product.ChooseProductTemplate')}}</h4>
      <hr>
      <div class="radio-layout">
        <input type="radio" name="layouts" id="layoutOne" checked>
        <label for="layoutOne">
          <span class="title">{{$t('product.Test')}} <a href="#" class="btn btn-default btn-action" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
          <span class="layout"><img src="/hub/images/placeholder/no-image.svg" alt="Layout title"></span>
          <span class="layout-content">
            <span class="description">{{$t('product.BriefDescriptionPrompt')}}</span>
          </span>
        </label>
      </div>
      <div class="radio-layout">
        <input type="radio" name="layouts" id="layoutTwo">
        <label for="layoutTwo">
          <span class="title">{{$t('product.TestTwo')}} <a href="#" class="btn btn-default btn-action" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
          <span class="layout"><img src="/hub/images/placeholder/no-image.svg" alt="Layout title"> </span>
          <span class="layout-content">
            <span class="description">{{$t('product.BriefDescriptionPrompt')}}</span>
          </span>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
};
</script>