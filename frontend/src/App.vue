<template>
  <div>
    <a href="#/">Home</a> |
    <a href="#/random-item">Random 100 Item</a> |
    <a href="#/insert-user">Insert User</a> |
    <a href="#/update-user">Update User</a> |
    <a href="#/delete-user">Delete User</a> |
    <a href="#/list-user">List User</a> |
    <a href="#/user-login">User Login</a> |
    <component :is="currentView" />
  </div>
</template>

<script>
import RandomItem from './RandomItem.vue'
import InsertUser from './InsertUser.vue'
import UpdateUser from './UpdateUser.vue'
import DeleteUser from './DeleteUser.vue'
import ListUser from './ListUser.vue'
import UserLogin from './UserLogin.vue'

const routes = {
  '/random-item': RandomItem,
  '/insert-user': InsertUser,
  '/update-user': UpdateUser,
  '/delete-user': DeleteUser,
  '/list-user': ListUser,
  '/user-login': UserLogin
}

export default {
  data() {
    return {
      currentPath: window.location.hash
    }
  },
  computed: {
    currentView() {
      return routes[this.currentPath.slice(1) || '/']
    }
  },
  mounted() {
    window.addEventListener('hashchange', () => {
      this.currentPath = window.location.hash
    })
  }
}
</script>