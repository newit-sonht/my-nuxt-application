<template>
  <form class="ui form" @submit.prevent="onSubmit">
    <h2>Create new account !!</h2>
    <!-- Email -->
    <div class="field">
      <label>Email</label>
      <input required type="email" name="email" placeholder="Email" v-model="data.email">
    </div>
    <!-- Password -->
    <div class="field">
      <label>Password</label>
      <input required type="password" name="pw" placeholder="Password" v-model="data.password">
    </div>
    <!-- Checkbox -->
    <div class="field">
      <div class="ui checkbox">
        <input required type="checkbox" tabindex="0">
        <label>I agree to the Terms and Conditions</label>
      </div>
    </div>
    <button class="ui button" type="submit">Submit</button>
  </form>
</template>

<style scoped>
  h1, h2, h3 {
    text-align: center;
  }
</style>

<script>
export default {
  name: 'SignupComponent',
  data() {
    return {
      data: {
        email: 'test@test.com',
        password: 'test123',
        returnSecureToken: true
      }
    }
  },
  methods: {
    onSubmit() {
      this.$emit('submit',this.data);
    }
  },
}
</script>
