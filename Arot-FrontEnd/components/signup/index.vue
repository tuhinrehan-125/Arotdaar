<template>
  <v-dialog v-model="isOpened" persistent max-width="600px">
    <v-card>
      <v-toolbar dark color="info">
        <v-toolbar-title>{{ $t("signup") }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn text @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-text>
        <v-form class="mt-5" ref="signup" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12">
              <v-text-field
                :label="$t('name')"
                :rules="nameRules"
                outlined
                v-model="form.name"
                dense
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                :label="$t('email')"
                :rules="emailRules"
                v-model="form.email"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                :label="$t('business_name')"
                outlined
                dense
                v-model="form.busniess_name"
                :rules="bnameRules"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                :label="$t('password')"
                outlined
                dense
                v-model="form.password"
                :rules="[rules.required, rules.min]"
                type="password"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="info darken-1" @click="closeModal">Close </v-btn>
        <v-btn color="teal darken-1" :loading="isLoading" @click="submitForm"
          >Sign Up
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name:"signupform",
  head: {
    title: "",
  },
  components: {},
  data() {
    return {
      isLoading: false,
      dialog: true,
      tab: 0,
      valid: true,
      form: {
        name: "",
        email: "",
        busniess_name: "",
        password: "",
      },
      verify: "",
      loginPassword: "",
      loginEmail: "",
      nameRules: [(v) => !!v || this.$t("required")],
      bnameRules: [(v) => !!v || this.$t("required")],
      emailRules: [
        (v) => !!v || this.$t("required"),
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      rules: {
        required: (value) => !!value || this.$t("required"),
        min: (v) => (v && v.length >= 8) || "Min 8 characters",
      },
    };
  },
  methods: {
    closeModal() {
      this.$store.commit("SET_MODAL", false);
    },
    async submitForm() {
      if (this.$refs.signup.validate()) {
        try {
          this.isLoading = true;
          await this.$axios
            .post("auth/signup", this.form)
            .then((res) => {
              this.isLoading = false;
              this.$emit("signupComplete");
            })
            .catch((err) => {
              this.isLoading = false;
              cosnole.log(err);
            });
        } catch (e) {
          this.isLoading = false;
          this.error = e.response.data.message;
        }
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
  mounted() {},

  computed: {
    isOpened() {
      return this.$store.getters.modal;
    },
    passwordMatch() {
      return () => this.password === this.verify || "Password must match";
    },
  },
};
</script>
<style scoped>
.v-centered {
  margin-top: 145px;
}
.v-application .pa-7 {
  padding: 15px !important;
}
</style>
