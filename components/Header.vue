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
        <a href="/private" class="item">
            Private
        </a>
        <a href="/son" class="item">
            Son
        </a>
        <div class="right menu">
          <a class="ui item" @click="logout">
              Logout
          </a>
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

<script>

export default ({
  name: "Header",
  methods: {
    logout() {
      this.$store.dispatch('logout');
      this.$router.push('/authen/signin')
    }
  },
})
</script>

