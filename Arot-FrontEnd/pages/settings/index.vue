<template>
  <v-container fluid>
    <v-row justify="center">
      <base-material-snackbar
        v-model="alert"
        type="success"
        v-bind="{
          [parsedDirection[0]]: true,
          [parsedDirection[1]]: true,
        }"
      >
        {{ message }}
      </base-material-snackbar>
      <v-col cols="12" sm="12" md="12">
        <v-card>
          <v-card-title>
            {{ $t("settings") }}
          </v-card-title>
          <v-card-text>
            <v-row no-gutters justify="center">
              <v-col cols="12" md="8">
                <v-row justify="center">
                  <v-col cols="12">
                    <v-form>
                      <v-container class="py-0">
                        <v-row>
                          <v-col cols="12" md="6" xl="4">
                            <v-text-field
                              outlined
                              dense
                              v-model="form.arot_commission"
                              label="Arot Commission"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" md="6" xl="4">
                            <v-text-field
                              outlined
                              dense
                              v-model="form.bazar_commission"
                              label="Bazar Commission"
                              required
                            ></v-text-field>
                          </v-col>

                          <v-col cols="12" md="6" xl="4">
                            <v-text-field
                              outlined
                              dense
                              v-model="form.arot_name"
                              label="Arot Name"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" md="6" xl="4">
                            <v-text-field
                              outlined
                              dense
                              v-model="form.arot_phone"
                              label="Arot Phone No"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" md="6" xl="4">
                            <v-text-field
                              outlined
                              dense
                              v-model="form.arot_address"
                              label="Arot Address"
                              required
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" md="6" xl="4">
                            <img
                              v-if="arot_image"
                              :src="arot_image"
                              style="
                                width: 100%;
                                height: 200px;
                                margin-bottom: 10px;
                              "
                            />
                            <v-file-input
                              label="Photo"
                              outlined
                              v-model="form.image"
                              dense
                            ></v-file-input>
                          </v-col>

                          <v-col cols="12" class="text-right">
                            <v-btn
                              color="primary"
                              min-width="150"
                              @click="saveCommission()"
                            >
                              Save
                            </v-btn>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-form>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "settings",
  head: {
    title: "",
  },
  components: {},
  data() {
    return {
      arot_image: null,
      message: "",
      direction: "top right",
      alert: false,
      form: {
        arot_name: "",
        arot_commission: "",
        bazar_commission: "",
        arot_address: "",
        arot_phone: "",
        image: null,
      },
    };
  },
  computed: {
    parsedDirection() {
      return this.direction.split(" ");
    },
    user() {
      return this.$auth.user.data;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.settings();
  },
  methods: {
    async settings() {
      await this.$axios.get("/settings").then((res) => {
        this.form.arot_commission = res.data.setting.arot_commission!=='null'?res.data.setting.arot_commission:'';
        this.form.bazar_commission = res.data.setting.bazar_commission!='null'?res.data.setting.bazar_commission:'';
        this.arot_image = res.data.setting.arot_image;
        this.form.arot_name = res.data.setting.arot_name!='null'?res.data.setting.arot_name:'';
        this.form.arot_address = res.data.setting.arot_address!='null'?res.data.setting.arot_address:'';
        this.form.arot_phone = res.data.setting.arot_phone!='null'?res.data.setting.arot_phone:'';
      });
    },
    async saveCommission() {
      let formData = new FormData();
      formData.append("arot_commission", this.form.arot_commission);
      formData.append("bazar_commission", this.form.bazar_commission);
      formData.append("arot_image", this.form.image);
      formData.append("arot_name", this.form.arot_name);
      formData.append("arot_address", this.form.arot_address);
      formData.append("arot_phone", this.form.arot_phone);
      await this.$axios
        .post("update-settings", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.message = "Settings Updated successfully";
          this.alert = true;
          this.settings();
        });
    },
  },
};
</script>

<style>
</style>
