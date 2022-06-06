<template>
  <div>

    <button type="button" class="ui button" @click="directToMainPage">Go to home page</button>

  </div>
</template>

<script>
export default {
    name: 'SonTestPage',
    layout: 'main_layout',
    methods: {
      directToMainPage() {
        window.location.href = '/';
      }
    },
}
</script>
