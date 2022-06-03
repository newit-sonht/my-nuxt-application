<template>
  <h1> This is the default card page when no id existed ! </h1>
</template>

<script>
export default {
  name: "CardDetail",
  layout: 'main_layout',
  middleware: ['check-auth','auth'],
}
</script>
