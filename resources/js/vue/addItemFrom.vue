<template>
  <div class="addItem">
    <input type="text" placeholder="appName" v-model="item.appName" />
    <input type="text" placeholder="password" v-model="item.password" />
    <input type="text" placeholder="description" v-model="item.description" />
    <font-awesome-icon
      icon="plus-square"
      @click="addPass()"
      :class="[item.name ? 'active' : 'inactive', 'plus']"
    />
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      item: {
        appName: "",
        password: "",
        description: "",
      },
    };
  },
  methods: {
    addPass() {
      if (
        this.item.appName == "" ||
        this.item.password == "" ||
        this.item.description == ""
      ) {
        return console.log("Заполните поля");
      }
      console.log(this.item);
      axios
        .post("api/v1/set-password", {
          item: this.item,
        })
        .then((res) => {
          console.log(res);
          if (res.status == 201) {
            this.item.appName = "";
            this.item.password = "";
            this.item.description = "";
            // this.$emit("reloadlist");
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
.addItem {
  display: flex;
  justify-content: center;
  align-items: center;
}
input {
  background: #f7f7f7;
  border: 0px;
  outline: none;
  padding: 5px;
  margin-right: 10px;
  width: 100%;
}

.plus {
  font-size: 20px;
}

.active {
  color: #00ce25;
}

.inactive {
  color: #999999;
}
</style>