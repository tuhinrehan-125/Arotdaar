<template>
  <v-container fluid grid-list-xl class="mt-5">
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
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-toolbar dark color="primary">
            <v-toolbar-title>{{ headline }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="dialog = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>

          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-select
                    :items="['Bank', 'Bkash', 'Rocket']"
                    :label="$t('account_type')"
                    outlined
                    dense
                    v-model="form.type"
                  ></v-select>
                </v-col>
                <template v-if="form.type == 'Bank'">
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('bank_name')"
                      outlined
                      dense
                      v-model="form.bank_name"
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-text-field
                      :label="$t('bank_acc')"
                      v-model="form.bank_acc"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('bank_branch')"
                      v-model="form.bank_branch"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                </template>
                <template v-if="form.type == 'Bkash'">
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('bkash_number')"
                      required
                      outlined
                      dense
                      type="number"
                      v-model="form.bkash_number"
                    ></v-text-field>
                  </v-col>
                </template>
                <template v-if="form.type == 'Rocket'">
                  <v-col cols="12">
                    <v-text-field
                      :label="$t('rocket_number')"
                      outlined
                      dense
                      v-model="form.rocket_number"
                    ></v-text-field>
                  </v-col>
                </template>
              </v-row>
            </v-container>
            <small>{{ $t("indicates_required_field") }}</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t("close") }}
            </v-btn>
            <v-btn color="blue darken-1" text @click="addAccount">
              {{ $t("save") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="confirmation" max-width="300">
        <v-card>
          <v-card-title>
            Are you sure?
            <v-spacer />
            <v-icon aria-label="Close" @click="confirmation = false">
              mdi-close
            </v-icon>
          </v-card-title>
          <v-card-text class="pb-6 pt-12 text-center">
            <v-btn class="mr-3" text @click="confirmation = false"> No </v-btn>
            <v-btn color="success" text @click="confirmDelete()"> Yes </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col>
        <v-btn dark color="indigo" class="float-right" @click="dialog = true">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("add_account") }}
        </v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("account_list") }}
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers" :items="accounts" :search="search">
              <!-- <template v-slot:item.actions="{ item }">
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="cyan"
                  @click="editClient(item)"
                >
                  <v-icon dark> mdi-pencil </v-icon>
                </v-btn>
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="red"
                  @click="deleteClient(item)"
                >
                  <v-icon dark> mdi-delete </v-icon>
                </v-btn>
              </template> -->
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Accounts",
  middleware: "auth",
  head: {
    title: "Accounts",
  },
  components: {},
  data() {
    return {
      search: "",
      isLoading: false,
      alert: false,
      dialog: false,
      update: false,
      message: "",
      headline: this.$t("add_account"),
      confirmation: false,
      direction: "top right",
      form: {
        bank_name: "",
        type: "",
        bank_acc: "",
        bank_branch: "",
        bkash_number: "",
        rocket_number: "",
      },
      accounts: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("account_type"),
          value: "type",
        },
        {
          sortable: false,
          text: this.$t("bank_name"),
          value: "bank_name",
        },
        {
          sortable: false,
          text: this.$t("bank_acc"),
          value: "bank_acc",
        },
        {
          sortable: false,
          text: this.$t("bank_branch"),
          value: "bank_branch",
        },
        {
          sortable: false,
          text: this.$t("bkash_number"),
          value: "bkash_number",
        },
        {
          sortable: false,
          text: this.$t("rocket_number"),
          value: "rocket_number",
        },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getAccounts();
  },
  methods: {
     async getAccounts() {
      this.isLoading = true;
      await this.$axios
        .get("/payment-account")
        .then((response) => {
          this.isLoading = false;
          this.accounts = response.data.data;
        })
        .catch((err) => {
          console.log("error");
        });
    },
    async addAccount() {
      if (this.update == false) {
        await this.$axios.post("payment-account", this.form).then((res) => {
          this.form={}
          this.message = "Payment Accout Addedd successfully";
          this.dialog = false;
          this.alert = true;
          this.getAccounts();
        });
      } else {
        await this.$axios
          .patch(`client/${this.clienttid}`, this.form)
          .then((res) => {
            this.message = "Client info Updated successfully";
            this.dialog = false;
            this.alert = true;
            this.getAccounts();
          });
      }
    },
    confirmDelete() {},
  },
};
</script>

<style>
</style>
