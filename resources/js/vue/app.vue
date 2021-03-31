<template>
  <div class="todoListContainer">
    <div class="heading">
      <h2 id="title">PasswordManager</h2>
      <div>Выводится в консоль</div>
      <add-item-from />
       <get-item />
    </div>
   
    <!-- <list-view :items="items" v-on:reloadlist="getList()" /> -->
  </div>
</template>

<script>
import AddItemFrom from "./addItemFrom.vue";
import GetItem from "./getItem.vue";

export default {
  components: {
    AddItemFrom,
    GetItem,
  },
  data: () => {
    return {
      items: [],
    };
  },
};
</script>

<style scoped>
.todoListContainer {
  width: 350px;
  margin: auto;
}

.heading {
  background: #e6e6e6;
  padding: 10px;
}

#title {
  text-align: center;
}
</style>