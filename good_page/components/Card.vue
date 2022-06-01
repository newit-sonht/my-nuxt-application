<template>
<a :href="'/card/' + _id" class="ui card">
    <div class="content" style="user-select: auto;">
        <div class="right floated meta" style="user-select: auto;">14h</div>
        <img class="ui avatar image"
             v-bind:src="user_avatar"> {{ user_name }}
    </div>
    <div class="image content" style="user-select: auto;">
        <img v-bind:src="image_content" />
    </div>
    <div class="content" style="user-select: auto;">
        <span class="right floated" style="user-select: auto;">
            <i class="heart outline like icon" style="user-select: auto;"></i>
            {{ convert_number(like_count) }}
        </span>
        <i class="comment icon" style="user-select: auto;"></i>
        {{ convert_number(comment_count) }} comments
    </div>
</a>
</template>
<style scoped>
  a {
    color: unset;
  }
  img {
    width: 282px;
  }
  .image.content {
    min-height: 289px;
    max-height: 290px;
    max-width: 290px;
    overflow: hidden;
    padding: 0 !important;
  }
</style>

<script>
export default {
  props: {
    _id: {
      type: String,
      required: false
    },
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
      type: [Number,String],
      default: 0
    },
    comment_count: {
      type: [Number,String],
      default: 0
    }
  },
  methods: {
    convert_number (value){
      if(value > 1000000) return value/1000000 + 'M';
      else if(value > 1000) return value/1000 + 'K';
      return value;
    }
  },
}
</script>
