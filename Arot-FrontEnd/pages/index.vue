<template>
  <v-container class="v-centered">
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
    <v-row align="center" justify="center">
      <v-col cols="12" md="4" lg="4">
        <base-material-card
          elevation="10"
          color="info"
          class="login-card d-flex align-content-center flex-wrap"
        >
          <template v-slot:heading>
            <div class="display-2 font-weight-light text-center">
              আড়ৎদার লগিন
            </div>
            <!-- <div class="subtitle-1 font-weight-light text-center">
              Login to Start your session
            </div> -->
          </template>
          <v-card-text>
            <v-form
              ref="loginForm"
              method="post"
              v-model="valid"
              lazy-validation
              v-on:submit="validate"
            >
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.email"
                    :rules="loginEmailRules"
                    :label="$t('email')"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.password"
                    :append-icon="show1 ? 'eye' : 'eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="show1 ? 'text' : 'password'"
                    name="input-10-1"
                    :label="$t('password')"
                    hint="At least 8 characters"
                    autocomplete="off"
                  >
                    @click:append="show1 = !show1" ></v-text-field
                  >
                </v-col>
                <!-- <v-col class="d-flex" cols="12" sm="6" xsm="12">
                  <p><b>Email</b>:admin@gmail.com</p>
                  &nbsp;
                  <p><b>Password</b>:admin1234</p>
                </v-col> -->

                <v-col cols="12" md="12" xl="12" sm="4" xsm="12" align="right">
                  <v-btn
                    type="submit"
                    medium
                    :disabled="!valid"
                    color="info"
                    elevation="7"
                    :loading="isLoading"
                  >
                    {{ $t("login") }}
                  </v-btn>
                </v-col>
                <v-col cols="12" md="12" xl="12" sm="4" xsm="12" align="right">
                  {{ $t("no_acc_yet") }}
                  <a @click="signupForm"> {{ $t("signup") }}</a>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </base-material-card>
      </v-col>
      <signup-form v-if="active" @signupComplete="signupComplete()" />
    </v-row>
  </v-container>
</template>

<script>
import signupForm from "@/components/signup/index";
export default {
  name: "Login",
  layout: "login",
  middleware: "auth",
  head: {
    title: "Login",
  },
  components: { signupForm },
  data() {
    return {
      alert: false,
      message: "",
      active: false,
      isLoading: false,
      dialog: true,
      tab: 0,
      valid: true,
      form: {
        email: "",
        password: "",
      },
      direction: "top right",
      verify: "",
      loginPassword: "",
      loginEmail: "",
      loginEmailRules: [
        (v) => !!v || this.$t("required"),
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      emailRules: [
        (v) => !!v || this.$t("required"),
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      show1: false,
      rules: {
        required: (value) => !!value || this.$t("required"),
        min: (v) => (v && v.length >= 8) || "Min 8 characters",
      },
    };
  },
  methods: {
    signupComplete() {
      this.alert = true;
      this.message = "Signup Successfull";
      this.active = false;
      this.$store.commit("SET_MODAL", false);
    },
    signupForm() {
      this.active = true;
      this.$store.commit("SET_MODAL", true);
    },
    async validate(e) {
      e.preventDefault();
      if (this.$refs.loginForm.validate()) {
        try {
          this.isLoading = true;
          await this.$axios.get("csrf-cookie");
          await this.$auth.loginWith("local", {
            data: this.form,
          });
          this.$axios.get("auth/userinfo").then(res=>{
            this.$auth.setUser(res.data)
          })
          this.isLoading = false;
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
    parsedDirection() {
      return this.direction.split(" ");
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
