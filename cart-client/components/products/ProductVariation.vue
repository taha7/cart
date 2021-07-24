<template>
  <div class="field">
    <label for="" class="label">
      {{ type }}
    </label>
    <div class="control">
      <div class="select is-fullwidth">
        <select :value="selectedVariationId" @change="changed($event, type)">
          <option disabled value="">Please choose</option>
          <option
            v-for="variation in variations"
            :key="variation.id"
            :value="variation.id"
            :selected="value === variation.id"
            :disabled="!variation.in_stock"
          >
            {{ variation.name }}

            <template v-if="variation.price_varies">
              ({{ variation.price }})
            </template>

            <template v-if="!variation.in_stock"> (out of stock) </template>
          </option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["type", "variations", "value"],
  methods: {
    changed(event, type) {
      this.$emit("input", this.findVariationById(event.target.value));
    },

    findVariationById(id) {
      const variation = this.variations.find((v) => v.id == id);

      if (typeof variation === "undefined") {
        return null;
      }

      return variation;
    },
  },
  computed: {
    selectedVariationId() {
      if (!this.findVariationById(this.value.id)) {
        return "";
      }
      return this.value.id;
    },
  },
};
</script>

<style></style>
