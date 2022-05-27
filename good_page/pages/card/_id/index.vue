<template>
<div class="container">

  <!-- Action navigation -->
  <div class="action_navigation">
    <nuxt-link to="/">
      <button type="button" class="ui left floated button">Home</button>
    </nuxt-link>
    <nuxt-link :to="'/card/' + this.$route.params.id + '/edit'">
      <button type="button" class="ui right floated green button">Edit</button>
    </nuxt-link>
  </div>
  <div class="ui divider"></div>

  <!-- Card Detail Display -->

  <!-- Avatar, Username and Other -->
  <div class="field avatar">
    <img class="ui medium circular image" :src="my_data.user_avatar" />
    <h1> {{ my_data.user_name }} </h1>
  </div>
  <div class="social">
    <div class="ui compact menu">
      <a class="item" style="user-select: auto;">
        <i class="thumbs up icon" style="user-select: auto;"></i> Like
        <div class="floating ui red label" style="user-select: auto;">{{ my_data.like_count }}</div>
      </a>
      <a class="item" style="user-select: auto;">
        <i class="comment icon" style="user-select: auto;"></i> Comment
        <div class="floating ui teal label" style="user-select: auto;">{{ my_data.comment_count }}</div>
      </a>
    </div>
  </div>

  <div class="content_image">
    <img class="ui fluid image" :src="my_data.image_content" alt="image content"/>
  </div>
</div>
</template>

<style scoped>
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
    padding-bottom: 150px;
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
  .container {
    align-items: center;
    align-content: center;
    width: 50vw;
    margin: auto;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    box-sizing: border-box;
    padding: 35px;
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
  asyncData(context) {
    return axios.get('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy/' + context.params.id + '.json')
      .then(res => {
        return {
          my_data: res.data
        }
      })
      .catch(e => console.log(e));
  },
}
</script>
