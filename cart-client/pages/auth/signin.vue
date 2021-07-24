<template>
  <div class="section">
    <div class="container is-fluid">
      <div class="columns is-centered">
        <div class="column is-6">
          <h1 class="title is-4"></h1>
          <form action="" @submit.prevent="signin2">
            <div class="field">
              <label for="email" class="label">Email</label>
              <div class="control">
                <input
                  v-model="form.email"
                  type="email"
                  class="input"
                  placeholder="e.g. taha@example.com"
                />
              </div>
            </div>

            <div class="field">
              <label for="password" class="label">Password</label>
              <div class="control">
                <input type="password" class="input" v-model="form.password" />
              </div>
            </div>

            <div class="field">
              <p class="control">
                <button type="submit" class="button is-info is-medium">Sign in</button>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    async signin2() {
      try {
        console.log("hhhhhhhhhhhhhhhhh");
        await this.$auth.loginWith("local", {
          data: this.form,
        });
        console.log(this.$auth.$state);
      } catch (e) {
        console.log(e.response.data);
      }
    },
  },
};
</script>

<style>
</style>
