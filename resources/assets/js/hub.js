
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

var ApiRequest  = require('./classes/ApiRequest');
var Dispatcher  = require('./classes/Dispatcher');
var Locale      = require('./classes/Locale');
var Config      = require('./classes/Config');

require('./bootstrap');
require('./classes/Errors');
require('./classes/Form');

require('./components');
require('babel-core/register');
require('babel-polyfill');
require('bootstrap-datepicker');
require('bootstrap-select');
require('bootstrap-switch');
require('bootstrap-tagsinput');
require('dropzone');
require('lity');
require('selectize');

import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import icons from '@fortawesome/fontawesome-free-solid'
import fontawesome from '@fortawesome/fontawesome'
fontawesome.library.add(icons)

Vue.component('fa', FontAwesomeIcon);

/**
 * Bind some bits to the window for usage.
 */

window.apiRequest     = new ApiRequest();
window.CandyEvent     = new Vue();
window.channels       = [];
window.config         = new Config();
window.Dispatcher     = new Dispatcher();
window.languages      = [];
window.List           = require('list.js');
window.locale         = new Locale();
window.moment         = require('moment');
window.defaultChannel = document.head.querySelector('meta[name="channel"]').content;

// Include our custom v stuff here, so we know everything is loaded

require('./directives/sortable');
import Vue from 'vue'
import Vuex from 'vuex'
import { VTooltip } from 'v-tooltip'
import VueLazyload from 'vue-lazyload'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n);
Vue.use(Vuex);
Vue.use(VueLazyload, {
  lazyComponent: true
});

require('./filters/attributes');
require('./filters/format-date');
require('./filters/translate');

require('chart.js');
require('chartjs-color');

Vue.filter('capitalize', function (value) {
  if (!value) return value;
  value = value.toString()
  return value.charAt(0).toUpperCase() + value.slice(1)
})

const store = new Vuex.Store({
  state: {
    topTabs: {},
    taxes: [],
    defaultChannel: {
      handle: defaultChannel
    }
  },
  mutations: {
    addTab (state, tab) {
      state.topTabs.push(tab);
    },
    addTabs(state, tabs) {
      tabs.forEach(tab => {
        state.topTabs[tab.href] = tab;
      });
    },
    setDefaultChannel(state, channel) {
      state.defaultChannel = channel;
    },
    setTaxes(state, taxes) {
      state.taxes = taxes;
    }
  },
  getters: {
    getTopTabs(state) {
      return state.topTabs;
    },
    getDefaultChannel(state) {
      return state.defaultChannel;
    },
    getTaxes(state) {
      return state.taxes;
    }
  }
});

config.get('channels').then(response => {
  channels = response.data;
  var defaultChannel = _.filter(channels, function(channel) {
    // console.log(channel.default);
    return channel.default;
  });
  // console.log(defaultChannel[0]);
  store.commit('setDefaultChannel', defaultChannel[0]);
  // console.log(store.getters.getDefaultChannel);

});

config.get('taxes').then(response => {
  store.commit('setTaxes', response.data);
})

config.get('languages').then(response => {
  languages = response.data;
});

Vue.directive('tooltip', VTooltip);

var CandyHelpers = {};

CandyHelpers.install = function (Vue, options) {
  Vue.capitalize = function (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
};

const i18n = new VueI18n({
  locale: 'zh',
  messages:{
    'zh':{
      hello:'你好'
    },
    'en':{
      hello:'hello'
    }
  }
});


const app = new Vue({
    el: '#app',
    store,
    data: {
      title: ''
    },
    mounted() {
      CandyEvent.$on('title-changed', event => {
        if (event.prefix) {
          this.title = event.prefix + ' ';
        }
        if (_.isString(event.title)) {
          this.title = event.title;
        } else {
          this.title = this.$options.filters.attribute(event.title, 'name');
        }
      });
    }
});

Vue.use(CandyHelpers);

function formatMoney (n, c,t,d) {
  var
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

String.prototype.money = function (c,t,d) {
  return formatMoney(this, c,t,d);
}
Number.prototype.money = function (c, t, d) {
  return formatMoney(this, c, t, d);
}

window.axios.interceptors.response.use((response) => { // intercept the global error
  return response
}, function (error) {
  if (error.response.status === 401) {
      window.location.href = '/login';
      return;
  }
  // Do something with response error
  return Promise.reject(error)
});

/* Misc crap - need to remove!!! */

require('./misc.js');