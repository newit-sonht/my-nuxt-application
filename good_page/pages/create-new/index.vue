<template>
  <div>
    <div class="container">
      <CreateForm />
    </div>
  </div>
</template>

<style scoped>
  .container {
    width: 100%;
    box-shadow: black;

  }
  .container form {
    max-width: 800px;
    width: 90vw;
    margin: auto;
  }
</style>

<script>
import CreateForm from "@/components/create-new/CreateForm.vue";

export default {
    name: 'IndexPage',
    layout: 'main_layout',
    component: CreateForm
}
</script>
