<template>
  <form @submit.prevent="onSave" id="create_new_post" method="POST" action="" class="ui form">
    <h1>Enter your lady</h1>
    <div class="field" style="user-select: auto; max-width: 250px">
      <label for="her_id">Her id</label>
      <input required id="her_id" type="number" v-model="Post.id" placeholder="Your lady id" />
    </div>
    <div class="field" style="user-select: auto;">
      <label for="her_avatar">Her avartar</label>
      <input required id="her_avatar" type="text" v-model="Post.user_avatar" placeholder="Enter your lady avartar link" />
    </div>
    <div class="field" style="user-select: auto;">
      <label for="her_name">Her name</label>
      <input required id="her_name" type="text" v-model="Post.user_name" placeholder="Enter your lady name" />
    </div>
    <div class="field" style="user-select: auto;">
      <label for="her_image_content">Her image content</label>
      <input required id="her_image_content" type="text" v-model="Post.image_content" placeholder="Enter your lady content" />
    </div>
    <div class="field" style="user-select: auto; max-width: 250px">
      <label for="her_like_count">Her like count</label>
      <input required id="her_like_count" type="number" v-model="Post.like_count" placeholder="Your lady like count" />
    </div>
    <div class="field" style="user-select: auto; max-width: 250px">
      <label for="her_cmt_count">Her comment count</label>
      <input required id="her_cmt_count" type="number" v-model="Post.comment_count" placeholder="Your lady comment count" />
    </div>
    <button class="ui button" type="submit">  Ok, Let's public your lady </button>
  </form>
</template>

<script>
export default {
  props: {
    post: {
      type: Object,
      require: false
    }
  },
  data() {
    return {
      Post: this.post
      ? {...this.post}
      : {
        id:"0",
        user_avatar: '',
        user_name:"",
        image_content: '',
        like_count:"",
        comment_count:"",
      },
    }
  },
  methods: {
    onSave() {
      this.$emit('submit', this.Post);
      window.location.href = '/complete';
    }
  },
}
</script>
