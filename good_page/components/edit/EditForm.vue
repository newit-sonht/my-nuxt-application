<template>
<div>
  <h1> You can edit post in here : {{ this.$route.params.id }} </h1>
  <!-- Form -->
  <form class="ui form" @submit="updatePost">
    <div class="field">
      <label>User name</label>
      <input required type="text" placeholder="User name" v-model="my_data.user_name" />
    </div>
    <div class="field">
      <label>User avatar link</label>
      <input required type="text" placeholder="User avatar link" v-model="my_data.user_avatar" />
    </div>
    <div class="field">
      <label>Image Content</label>
      <input required type="text" placeholder="User avatar link" v-model="my_data.image_content" />
    </div>
    <div class="field">
      <div class="ui checkbox">
        <input required type="checkbox" tabindex="0" />
        <label>Tick on this text box or you can not submit</label>
      </div>
    </div>
    <!-- Button Nav -->
    <button class="ui right floated green button" type="submit">Submit</button>
    <nuxt-link to="/">
      <button class="ui button" type="button">Cancle</button>
    </nuxt-link>
  </form>
</div>
</template>

<script>
export default {
  name: "CardDetailEditComponent",
  layout: 'main_layout',
  props: {
    my_data : {
      type: Object,
      require: true
    }
  },
  data() {
    return {
      MyData: this.my_data
      ? {...this.my_data}
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
    updatePost() {
      this.$emit('submit',this.my_data);
    }
  },
}
</script>
