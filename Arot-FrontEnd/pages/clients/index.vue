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
               <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    class="smalltext"
                    :label="$t('clients_name')"
                    required
                    outlined
                    :rules="nameRules"
                    dense
                    v-model="form.name"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="$t('clients_address')"
                    outlined
                    dense
                    v-model="form.address"
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    :label="$t('phone_no')"
                    v-model="form.mobile_no"
                    outlined
                    dense
                    type="number"
                    :rules="[phonerules.required, phonerules.min]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="$t('company_name')"
                    v-model="form.company_name"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="$t('nid_no')"
                    required
                    outlined
                    dense
                    :rules="nidRules"
                    type="number"
                    v-model="form.nid_no"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field
                    :label="$t('commission_rate')"
                    outlined
                    dense
                    v-model="form.commission_rate"
                  ></v-text-field>
                </v-col>
              </v-row>
               </v-form>
            </v-container>
            <small>{{ $t("indicates_required_field") }}</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t("close") }}
            </v-btn>
            <v-btn color="blue darken-1" text @click="addClient">
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
          {{ $t("add_client") }}
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
            {{ $t("client_list") }}
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
            <v-data-table :headers="headers" :items="clients" :search="search">
              <template v-slot:item.actions="{ item }">
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
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Clients",
  middleware: "auth",
  head: {
    title: "Clients",
  },
  components: {},
  data() {
    return {
       valid: true,
      search: "",
      isLoading: false,
      alert: false,
      headline: this.$t("add_client"),
      dialog: false,
      update: false,
      message: "",
      clienttid: "",
      confirmation: false,
      direction: "top right",
      phonerules: {
        required: (value) => !!value || this.$t("required"),
        min: (v) => (v && v.length == 11) || this.$t("11_digit_required")
      },
      nidRules: [(v) => !!v || this.$t("required")],
      nameRules: [(v) => !!v || this.$t("required")],
      form: {
        name: "",
        mobile_no: "",
        address: "",
        nid_no: "",
        commission_rate: "",
        company_name: "",
      },
      clients: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("client_name"),
          value: "name",
        },
        {
          sortable: false,
          text: this.$t("address"),
          value: "address",
        },
        {
          sortable: false,
          text: this.$t("phone_no"),
          value: "mobile_no",
        },
        {
          sortable: false,
          text: this.$t("company_name"),
          value: "company_name",
        },
        {
          sortable: false,
          text: this.$t("nid_no"),
          value: "nid_no",
        },
        {
          sortable: false,
          text: this.$t("commission_rate"),
          value: "commission_rate",
        },
        {
          sortable: false,
          text: this.$t("due"),
          value: "due",
        },
        {
          sortable: false,
          text: this.$t("created"),
          value: "created_at",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
        },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getClients();
  },
  methods: {
    async getClients() {
      this.isLoading = true;
      await this.$axios
        .get("/client")
        .then((response) => {
          this.isLoading = false;
          this.clients = response.data;
        })
        .catch((err) => {
          console.log("error");
        });
    },
    editClient(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("edit_client");
      this.form.mobile_no = item.mobile_no;
      this.form.name = item.name;
      this.form.address = item.address;
      this.form.nid_no = item.nid_no;
      this.form.commission_rate = item.commission_rate;
      this.form.company_name = item.company_name;
      this.clienttid = item.id;
    },
    deleteClient(item) {
      this.confirmation = true;
      this.clienttid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`client/${this.clienttid}`).then((res) => {
        this.alert = true;
        this.message = "Client Deleted Successfully";
        this.confirmation = false;
        this.getClients();
      });
    },
    async addClient() {
      if (this.$refs.form.validate()) {
        if (this.update == false) {
          await this.$axios.post("client", this.form).then((res) => {
            this.form = {};
            this.$refs.form.reset();
            this.message = "Client Addedd successfully";
            this.dialog = false;
            this.alert = true;
            this.getClients();
          });
        } else {
          await this.$axios
            .patch(`client/${this.clienttid}`, this.form)
            .then((res) => {
              this.form = {};
              this.$refs.form.reset();
              this.message = "Client info Updated successfully";
              this.dialog = false;
              this.alert = true;
              this.getClients();
            });
        }
      }
    },
  },
  watch: {
    clients(val) {
      this.clients = val;
    },
  },
};
</script>

<style>
</style>
