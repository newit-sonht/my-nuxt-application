<template>
<header>
  <div class="ui secondary pointing menu">
        <div class="right menu">
          <a href="/authen/signup" class="item">
            Signup
          </a>
          <a href="/authen/signin" class="item">
            Signin
          </a>
        </div>
  </div>
  <div class="logo">
    <img src="https://www.fao.org/fileadmin/user_upload/soils-2015/images/EN/logo_only.jpg" alt="Logo Img"/>
    <h1 class="title"> My Lady </h1>
  </div>
</header>
</template>

<style scoped>
  a {
    font-size: 16px;
  }
  .divider{
    margin-bottom: 2rem;
  }
  header {
    border-top: 5px solid lightgreen;
    background-color: white;
  }
  .logo {
    display: flex;
    margin-bottom: 20px;
    flex-direction: column;
  }
  .logo img{
    width: 150px;
    margin: auto;
    border-radius: 50%;
  }
  h1 {
    text-align: center;
  }
  h1.title{
    margin: 10px;
  }
</style>

<script>
export default ({
  methods: {

  },
})
</script>
