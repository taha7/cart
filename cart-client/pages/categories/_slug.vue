<template>
   <div class="section">
      <div class="container is-fluid">
         <div class="columns is-multiline">
           <template v-if="products.length">
            <div class="column is-3" v-for="product in products" :key="product.slug">
               <Product :product="product" />
            </div>
           </template>
           <template v-else>
             <p>There is no products under this category</p>
           </template>
         </div>
      </div>
   </div>
</template>

<script>
import Product from "@/components/products/Product";
export default {
   data() {
      return {
         products: []
      };
   },

   components: {
      Product
   },

   async asyncData({ params, app }) {
      let response = await app.$axios.$get(`products?category=${params.slug}`);

      return {
         products: response.data
      };
   }
};
</script>

<style>
</style>
