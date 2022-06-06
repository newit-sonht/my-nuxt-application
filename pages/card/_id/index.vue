<template>
<form>
  <img class="premium" :src="my_data.image_content" alt="background-image" />
  <div class="container">
    <!-- Action navigation -->
    <div class="action_navigation">
      <nuxt-link to="/" v-if="my_data.enable">
        <button type="button" class="ui left floated button">
          <i class="angle left icon" style="user-select: auto;"></i>
          Home</button>
      </nuxt-link>
      <nuxt-link to="/private" v-else>
        <button type="button" class="ui left floated button">
          <i class="angle left icon" style="user-select: auto;"></i>
          Private Post</button>
      </nuxt-link>
      <nuxt-link :to="'/card/' + this.$route.params.id + '/edit'">
        <button type="button" class="ui right floated green button">Edit</button>
      </nuxt-link>
       <button type="button" class="ui right floated blue button" @click="setPostStatus" v-if="my_data.enable">Public</button>
       <button type="button" class="ui right floated red button" @click="setPostStatus" v-else>Private</button>
    </div>
    <div class="ui divider"></div>

    <!-- Card Detail Display -->

    <!-- Avatar, Username and Other -->
    <div class="field avatar">
      <div class="circle image">
        <img class="ui medium circular image" :src="my_data.user_avatar" />
      </div>
      <h1 class="title">
        {{ my_data.user_name }}
        <i v-if="my_data.like_count > 1000000" class="gem outline icon" style="user-select: auto;"></i>
      </h1>

    </div>
    <div class="social">
      <div class="ui compact menu">
        <a class="item" style="user-select: auto;">
          <i class="thumbs up icon" style="user-select: auto;"></i> Like
          <div class="floating ui red label" style="user-select: auto;">{{ convert_number(my_data.like_count) }}</div>
        </a>
        <a class="item" style="user-select: auto;">
          <i class="comment icon" style="user-select: auto;"></i> Comment
          <div class="floating ui teal label" style="user-select: auto;">{{ convert_number(my_data.comment_count) }}</div>
        </a>
      </div>
    </div>

    <div class="content_image">
      <img class="ui fluid image" :src="my_data.image_content" alt="image content"/>
    </div>
  </div>
</form>
</template>

<style scoped>
  .premium {
    position: absolute;
    top: -10px;
    z-index: -999;
    width: 99vw;
    opacity: 0.6;
  }
  .gem.outline.icon {
    background: -webkit-linear-gradient(#1138f7, #dc5ee0);
    background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  h1.title {
      margin-top: 15px !important;
  }
  @media screen and (max-width: 992px) {
    h1.title{
      font-size: 20px;
    }
  }
  button {
    width: 150px;
  }
  .social {
    width: fit-content;
    margin: auto;
    display: block;
  }
  .action_navigation{
    display: block;
    width: 100%;
    height: 35px;
  }
  .content_image{
    padding-top: 30px;
  }
  .content_image img{
    border: 1px solid #ddd; /* Gray border */
    border-radius: 4px;  /* Rounded border */
    padding: 15px; /* Some padding */
  }
  .field.avatar{
    height: 260px;
    overflow: hidden;
    margin-bottom: 5px;
  }
  .field.avatar h1{
    margin-top: 0;
    text-align: center;
  }
  .field.avatar img{
    width: 200px;
    margin: auto;
  }
  .small_text{
    font-size: 18px;
    font-style: italic;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 400;
    color: darkgray;
  }
</style>

<script>
import axios from 'axios'

export default {
  name: "CardDetail",
  layout: 'main_layout',
  middleware: ['check-auth','auth'],
  asyncData(context) {
    return axios.get('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy/' + context.params.id + '.json')
      .then(res => {
        return {
          my_data: { ...res.data, id: context.params.id }
        }
      })
      .catch(e => console.log(e));
  },
  methods: {
    convert_number (value){
      if(value > 1000000) return value/1000000 + 'M';
      else if(value > 1000) return value/1000 + 'K';
      return value;
    },
    setPostStatus() {
      this.$store.dispatch('setPostStatus', this.my_data)
      .then(() => {
        setTimeout(() => {
          window.location.href = "/";
        },1000)
      })
      .catch(e => console.log(e));
    }
  },
}
</script>
