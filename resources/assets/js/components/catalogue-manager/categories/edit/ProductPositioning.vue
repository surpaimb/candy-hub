<script>
    export default {
        data() {
            return {
                request: apiRequest,
                sortType: '',
                sortableOptions: {
                    onEnd: this.reorder,
                    filter: '.disabled',
                    handle: '.handle',
                    animation: 150
                }
            }
        },
        props: {
            categoryId: {
                type: String
            },
            sort: {
                type: String
            },
            products: {
                type: Array
            }
        },
        methods: {
            reorder ({oldIndex, newIndex}) {
                const movedItem = this.products.splice(oldIndex, 1)[0];
                this.products.splice(newIndex, 0, movedItem);
                this.updatePositions();
            },
            add(products) {
                this.products = products;
                this.updatePositions();
            },
            updatePositions() {
                let pos = 1;

                this.products.forEach(product => {
                    product.position = pos;
                    pos++;
                });

                this.save();
            },
            sortProducts() {
                if (this.sortType != 'custom') {
                    let sorts = this.sortType.split(':');
                    this.positioning = _.orderBy(this.positioning, 'object.max_price', sorts[1]);
                }
                this.updatePositions();
            },
            remove(index) {
                this.products.splice(index, 1);
                this.updatePositions();
            },
            save() {
                let payload = {
                    sort_type: this.sortType
                };
                payload.products = _.map(this.products, item => {
                    return {
                        id: item.id,
                        position: item.position ? item.position : 1
                    }
                });
                this.request.send('PUT', '/categories/' + this.categoryId + '/products', payload)
                    .then(response => {
                        CandyEvent.$emit('notification', {
                            level: 'success'
                        });
                    });
            }
        },
        computed: {
            positioning() {
                return _.map(this.products, product => {
                    return {
                        id: product.id,
                        position: product.position,
                        object: product
                    }
                });
            }
        },
        mounted() {
            this.sortType = this.sort;
        }
    }
</script>
<template>
    <div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{$t('category.ProductPositioning')}}</h4>
                            <span class="text-warning">{{$t('category.orderWillBeShown')}}</span>
                        </div>
                        <div class="col-md-2">
                            <candy-product-browser
                                :current="products"
                                :button-text="$t('category.AddProduct')"
                                :button-confirm="$t('category.AssociateProducts')"
                                @saved="add"
                            >
                            </candy-product-browser>
                        </div>
                        <div class="col-md-2">
                            <label>{{$t('category.Sorttype')}}</label>
                            <select v-model="sortType" class="form-control" @change="sortProducts">
                                <option value="min_price:asc">{{$t('category.PriceLowHigh')}}</option>
                                <option value="max_price:desc">{{$t('category.PriceHighLow')}}</option>
                                <option value="custom">{{$t('category.Custom')}}</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info" v-if="sortType != 'custom'">
                        <strong><i class="fa fa-exclamation-circle"></i> {{$t('category.PleaseNote')}}</strong>
                        <p>{{$t('category.OrderingPriceInfluenced')}}</p>
                    </div>

                    <table class="table table-striped sortable">
                        <thead>
                            <tr>
                                <th v-if="sortType == 'custom'"></th>
                                <th>{{$t('category.Product')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody  v-sortable="sortableOptions">
                            <tr v-for="(product, index) in positioning" :key="product.object.id">
                                <td class="handle" width="10%" v-if="sortType == 'custom'">
                                    <svg width="13px" viewBox="0 0 13 19" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="Artboard" fill="#D8D8D8">
                                                <rect id="Rectangle" x="2" y="2" width="3" height="3"></rect>
                                                <rect id="Rectangle-Copy-2" x="2" y="8" width="3" height="3"></rect>
                                                <rect id="Rectangle-Copy-4" x="2" y="14" width="3" height="3"></rect>
                                                <rect id="Rectangle-Copy-5" x="8" y="14" width="3" height="3"></rect>
                                                <rect id="Rectangle-Copy" x="8" y="2" width="3" height="3"></rect>
                                                <rect id="Rectangle-Copy-3" x="8" y="8" width="3" height="3"></rect>
                                            </g>
                                        </g>
                                    </svg>
                                </td>
                                <td>{{ product.object|attribute('name') }}</td>
                                <td align="right">
                                    <button class="btn btn-sm btn-default btn-action" @click="remove(index)">
                                        <i class="fa fa-trash-o" aria-hidden="true" :title="$t('common.Delete')"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</template>