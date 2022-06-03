<template>
    <div class="container">
      <div class="center_button">
        <i class="bath icon" style="user-select: auto;"></i>
      </div>
      <h1 class="success_green_text">Successfully!!!!</h1>
      <p class="dump_text_below"> I don't know what you had done, but you successfully </p>
      <div class="center_button">
        <nuxt-link to="/">
          <button class="ui button"> Return to home page </button>
        </nuxt-link>
      </div>

    </div>
</template>

<style scoped>
  i {
    font-size: 60px;
    color: #12a320;
    padding: 15px;
  }
  .center_button {
    display: flex;
  }
  .center_button i, .center_button a {
    margin: auto;
  }
  .success_green_text {
    color: #12a320;
    text-align: center;
  }
  .dump_text_below {
    color: #888a88;
    text-align: center;
    font-style: italic;
  }
</style>
