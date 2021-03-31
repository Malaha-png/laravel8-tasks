<template>
  <div class="item">
    <input type="text" v-model="item.id" />
    <button @click="getItem()">Получить по ID</button>
    <button @click="getAllItem()">Получить все</button>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      item: {
        id: "",
      },
    };
  },
  methods: {
    getItem() {
      console.log("getItem");
      axios
        .post("api/v1/password", {
          Authorization: "secret",
          item: this.item,
        })
        .then((res) => {
          if (res.status == 200) {
            console.log(res.data);
          } else {
            console.log(res);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getAllItem() {
      axios
        .post("api/v1/passwords", {
          Authorization: "secret",
        })
        .then((res) => {
          if (res.status == 200) {
            console.log(res.data);
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.item {
  padding-top: 10px;
}
input {
  background: #f7f7f7;
  border: 0px;
  outline: none;
  padding: 5px;
  margin-right: 10px;
  width: auto;
}

button {
  padding: 10px;
}
</style>