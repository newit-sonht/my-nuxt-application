<template>
<div>
    <div class="container">
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

  .container {
    align-items: center;
    align-content: center;
    width: 50vw;
    margin: auto;
  }
</style>

<script>
export default {
    name: 'IndexPage',
    computed: {
      LoadedCards() {
        return this.$store.getters.loadedPosts;
      }
    },
    layout: 'main_layout'
}
</script>


