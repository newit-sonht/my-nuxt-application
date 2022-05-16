<template>
<div class="ui card">
    <h3>{{ id }}</h3>
    <div class="content" style="user-select: auto;">
        <div class="right floated meta" style="user-select: auto;">14h</div>
        <img class="ui avatar image"
             v-bind:src="user_avatar"> {{ user_name }}
    </div>
    <div class="image" style="user-select: auto;">
        <img v-bind:src="image_content" />
    </div>
    <div class="content" style="user-select: auto;">
        <span class="right floated" style="user-select: auto;">
            <i class="heart outline like icon" style="user-select: auto;"></i>
            {{ like_count }}
        </span>
        <i class="comment icon" style="user-select: auto;"></i>
        {{ comment_count }} comments
    </div>
    <div class="extra content" style="user-select: auto;">
        <div class="ui large transparent left icon input" style="user-select: auto;">
            <i class="heart outline icon" style="user-select: auto;"></i>
            <input type="text" placeholder="Add Comment..." style="user-select: auto;">
        </div>
    </div>
</div>
</template>
<style scoped>
  img{
    width: 282px;
    height: 282px;
  }
</style>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    },
    user_avatar: {
      type: String,
      default: 'https://thuvienplus.com/themes/cynoebook/public/images/default-user-image.png'
    },
    user_name: {
      type: String,
      default: 'No Name'
    },
    image_content: {
      type: String,
      default: 'https://icons.iconarchive.com/icons/guillendesign/variations-3/256/Default-Icon-icon.png'
    },
    like_count: {
      type: String,
      default: "0"
    },
    comment_count: {
      type: String,
      default: "0c"
    }
  }
}
</script>
