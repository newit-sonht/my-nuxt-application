<template>
  <form id="create_new_post" method="POST" action="" class="ui form">
    <h1>New Post</h1>
    <div class="field" style="user-select: auto;">
      <label for="title">Title</label>
      <input id="title" placeholder="Enter your title" />
    </div>
    <div class="field" style="user-select: auto;">
      <label for="content">Descripiton</label>
      <textarea id="content" placeholder="Enter your title" ></textarea>
    </div>
    <button class="ui button" type="button"> Upload image </button>
  </form>
</template>
