<template>
  <v-dialog v-model="isOpened" persistent max-width="1000px">
    <v-card>
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
      <v-toolbar dark color="primary">
        <v-toolbar-title>{{ $t("add_payment") }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn dark text @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="4" md="4">
                <div class="cinfobox">
                  <p>{{ $t("client_name") }} :</p>
                  <p>{{ paymentinfo.client_name }}</p>
                </div>
              </v-col>
              <v-col cols="12" sm="4" md="4">
                <div class="cinfobox">
                  <p>{{ $t("invoice_no") }} :</p>
                  <p>{{ paymentinfo.invoice_no }}</p>
                </div>
              </v-col>
              <v-col cols="12" sm="4" md="4">
                <div class="cinfobox">
                  <p>{{ $t("total") }} :</p>
                  <p>{{ paymentinfo.payment_due }}</p>
                </div>
              </v-col>

              <v-col cols="12" sm="6" md="4">
                <p class="body-1">{{ $t("payment_via") }}</p>
                <v-select
                  :items="payment_from"
                  :label="$t('payment_via')"
                  dense
                  outlined
                  required
                  :rules="paymentfromRules"
                  item-text="name"
                  item-value="id"
                  v-model="form.select_mode"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="8">
                <p class="body-1">{{ $t("payment_details") }}</p>
                <v-card elevation="2">
                  <v-card-text>
                    <v-row>
                      <!-- <v-col cols="6" sm="6" md="6">
                      <p class="body-2">Client Name</p></v-col
                    >
                    <v-col cols="6" sm="6" md="6">
                      <v-select
                        :items="clients"
                        label="Select client name"
                        dense
                        outlined
                        required
                        v-model="form.client_id"
                        item-text="name"
                        item-value="id"
                      ></v-select>
                    </v-col> -->
                      <!-- for bank -->
                      <template v-if="bybank">
                        <v-col cols="6" sm="6" md="6">
                          <p class="body-2">{{ $t("bank_name") }}</p></v-col
                        >
                        <v-col cols="6" sm="6" md="6">
                          <v-select
                            :items="banks"
                            :label="$t('bank_name')"
                            dense
                            outlined
                            :required="!bybank"
                            :rules="bybank ? banknameRules : []"
                            v-model="form.bank_id"
                            item-text="name"
                            item-value="id"
                          ></v-select>
                        </v-col>
                        <v-col cols="6" sm="6" md="6">
                          <p class="body-2">{{ $t("acc_no") }}</p></v-col
                        >
                        <v-col cols="6" sm="6" md="6">
                          <v-text-field
                            :label="$t('acc_no')"
                            outlined
                            dense
                             :required="!bybank"
                            :rules="bybank ? bankidRules : []"
                            v-model="form.bank_code_id"
                          ></v-text-field>
                        </v-col>
                      </template>

                      <!-- for bank -->
                      <!-- for bkash -->
                      <template v-if="bybkash">
                        <v-col cols="6" sm="6" md="6">
                          <p class="body-2">{{ $t("from_bkash") }}</p></v-col
                        >
                        <v-col cols="6" sm="6" md="6">
                          <v-text-field
                            :label="$t('from_bkash')"
                            outlined
                            dense
                            :required="!bybkash"
                            :rules="bybkash ? frombkashRules : []"
                            v-model="form.from_bKash"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="6" md="6">
                          <p class="body-2">{{ $t("to_bkash") }}</p></v-col
                        >
                        <v-col cols="6" sm="6" md="6">
                          <v-text-field
                            :label="$t('to_bkash')"
                            outlined
                            dense
                            :required="!bybkash"
                            :rules="bybkash ? tobkashRules : []"
                            v-model="form.to_bKash"
                          ></v-text-field>
                        </v-col>
                      </template>

                      <!-- for bkash -->
                      <v-col cols="6" sm="6" md="6" class="subtitle-2">
                        <p class="body-2">{{ $t("amount") }}</p>
                      </v-col>
                      <v-col cols="6" sm="6" md="6">
                        <v-text-field
                          :label="$t('amount')"
                          outlined
                          dense
                          :rules="paymentamountRules"
                          v-model="form.amount"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="6" sm="6" md="6" class="subtitle-2">
                        <p class="body-2">{{ $t("advance_amount") }}</p>
                      </v-col>
                      <v-col cols="6" sm="6" md="6">
                        <v-text-field
                          :label="$t('advance_amount')"
                          outlined
                          dense
                          :disabled="form.adjust_advance==0"
                          v-model="form.adjust_advance"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
        <small>*indicates required field</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closeModal"> {{ $t("close") }} </v-btn>
        <v-btn color="blue darken-1" text @click="submitForm"> {{ $t("save") }} </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "addpayement",
  head: {
    title: "",
  },
  components: {},
  props: ["paymentinfo"],
  data() {
    return {
      accountInfo:{},
      valid: true,
      alert: false,
      clients: [],
      message: "",
      banks: [],
      bybkash: false,
      bybank: false,
      paymentfromRules: [v => !!v || "Payment from is required"],
      frombkashRules: [v => !!v || "From bkash number is required"],
      tobkashRules: [v => !!v || "To bkash number is required"],
      banknameRules:[v => !!v || "Bank name is required"],
      bankidRules:[v => !!v || "Bank ID is required"],
      paymentamountRules: [
        (v) => !!v || "Payment amount is required",
        (v) => v <= this.paymentinfo.payment_due || "Paying Amount must be less than due amount",
      ],
      payment_from: ["bKash", "Bank", "Cash"],
      form: {
        select_mode: "",
      },
      direction: "top right",
    };
  },
  computed: {
    isOpened() {
      return this.$store.getters.modal;
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
    async getAccountInfo(val)
    {
      await this.$axios.get("/account-info?type="+val).then((response) => {
        this.accountInfo= response.data.data
      });
    },
    async getClients() {
      await this.$axios.get("/client").then((response) => {
        this.clients = response.data;
      });
    },
    closeModal() {
      this.$store.commit("SET_MODAL", false);
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        await this.$axios.post("/payment", this.form).then((response) => {
          this.alert = true
          this.message = "Payment Addedd Successfulyy";
          this.$emit("payemntRefresh");
          this.form={},
          this.$refs.form.reset()
          setTimeout(() => this.$store.commit("SET_MODAL", false), 200);
        });
      }
    },
  },
  watch: {
    paymentinfo(val) {
      this.form.amount = val.payment_due;
      this.form.client_id = val.client_id;
      this.form.order_id = val.id;
      this.form.adjust_advance= val.advance_due
    },
    "form.select_mode"(val) {
      if (val == "Bank") {
        this.form.from_bKash = "";
        this.form.to_bKash = "";
        this.bybkash = false;
        this.bybank = true;
        this.getAccountInfo('Bank')
      } else if (val == "bKash") {
        this.form.bank_code_id = "";
        this.form.bank_id = "";
        this.bybkash = true;
        this.bybank = false;
        this.getAccountInfo('Bkash')
      } else {
        this.form.from_bKash = "";
        this.form.to_bKash = "";
        this.form.bank_code_id = "";
        this.form.bank_id = "";
        this.bybkash = false;
        this.bybank = false;
      }
    },
  },
};
</script>

<style scoped>
.cinfobox {
  border: 1px solid #e3e3e3;
  padding: 10px;
  background-color: #f5f5f5;
  height: 88px;
  border-radius: 5px;
}
.cinfobox p:first-child {
  font-weight: 600;
}
.actionlist .v-list-item {
  cursor: pointer;
}
.v-list-item:hover {
  background-color: #ccc;
}
</style>
