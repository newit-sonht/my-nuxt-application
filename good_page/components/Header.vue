<template>
<header>
    <div class="ui secondary pointing menu">
        <a href="#" class="item">
            <img src="https://www.fao.org/fileadmin/user_upload/soils-2015/images/EN/logo_only.jpg" alt="Logo" />
        </a>
        <a href="/" class="item">
            Home
        </a>
        <a href="/create-new" class="item">
            Create
        </a>
        <a href="/son" class="item">
            Son
        </a>
        <div class="right menu">
          <a href="/authen/signup" class="item">
            Signup
          </a>
          <a href="/authen/signin" class="item">
            Signin
          </a>
            <!-- <a class="ui item">
                Logout
            </a> -->
        </div>
    </div>
    <div class="divider"></div>
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
</style>
