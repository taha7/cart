<template>
  <div class="section">
    <div class="container isfluid">
      <div class="columns">
        <div class="column is-12">
          <h1 class="title is-4">
            Your Orders
          </h1>

          <article class="message">
            <div class="message-body">
              <table class="table is-hoverable is-fullwidth">
                <tbody>
                  <Order />
                </tbody>
              </table>
            </div>
          </article>
          <p>You have no orders</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Order from "@/components/orders/Order.vue";
export default {
  components: {
    Order
  },
  data() {
    return {
      orders: []
    };
  },
  async asyncData({ app }) {
    const { data } = await app.$axios.$get("orders");

    return {
      orders: data
    };
  }
};
</script>

<style></style>
