<template>
<div>
    <div class="main_page">
        <div class="ui link cards">
            <Card v-for="item in LoadedCards"
              :key="item.id"
              :id="item.id"
              :user_avatar="item.user_avatar"
              :user_name="item.user_name"
              :image_content="item.image_content"
              :like_count="item.like_count"
              :comment_count="item.comment_count"
              :_id="item._id"
              :enable="item.enable"
            />
        </div>
        <div class="divider"></div>
    </div>
</div>
</template>

<style scoped>
  .divider {
    height: 15vh;
  }

  .main_page {
    align-items: center;
    align-content: center;
    width: 60vw;
    margin: auto;
  }
</style>

<script>
export default {
    name: 'IndexPage',
    middleware: ['check-auth','auth'],
    computed: {
      LoadedCards() {
        return this.$store.getters.loadedPosts;
      }
    },
    layout: 'main_layout'
}
</script>


