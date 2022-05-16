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
    width: 800px;
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
