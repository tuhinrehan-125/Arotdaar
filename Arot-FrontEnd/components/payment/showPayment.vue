<template>
  <v-dialog v-model="isOpened" max-width="600">
    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title> {{$t('payment_info')}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn dark text @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="6" sm="6" md="6"
              ><p class="font-weight-bold">{{ $t("invoice_no") }} :</p></v-col
            >
            <v-col cols="6" sm="6" md="6">
              {{ data.invoice_no }}
            </v-col>
            <v-col cols="6" sm="6" md="6"
              ><p class="font-weight-bold">{{ $t("client_name") }} :</p>
            </v-col>
            <v-col cols="6" sm="6" md="6">
              {{ data.client_name }}
            </v-col>
            <v-col cols="6" sm="6" md="6"
              ><p class="font-weight-bold">{{ $t("total") }} :</p>
            </v-col>
            <v-col cols="6" sm="6" md="6">
              {{ data.total }} {{$t('amount')}}
            </v-col>
            <v-col cols="6" sm="6" md="6"
              ><p class="font-weight-bold">{{ $t("total_paid") }} :</p>
            </v-col>
            <v-col cols="6" sm="6" md="6">
              {{ data.total_paid }} {{$t('amount')}}
            </v-col>
            <v-col cols="6" sm="6" md="6"
              ><p class="font-weight-bold">{{ $t("due") }} :</p>
            </v-col>
            <v-col cols="6" sm="6" md="6">
              {{ data.payment_due }} {{$t('amount')}}
            </v-col>
            <template v-if="data.paymentinfo.length > 0">
              <v-col cols="12" sm="12" md="12">
                <p class="font-weight-bold text-center mb-5">{{$t('payment_history')}}</p>
                <v-card elevation="2" style="width: 100%">
                  <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">{{ $t("date") }}</th>
                          <th class="text-left">{{ $t("amount") }} </th>
                          <th class="text-left">{{ $t("payment_method") }}</th>
                          <th class="text-left">{{ $t("payment_info") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(item, index) in data.paymentinfo"
                          :key="index"
                        >
                          <td width="120px">{{ item.date }}</td>
                          <td>{{ item.amount }} </td>
                          <td width="150px">{{ item.mode }}</td>
                          <td v-if="item.mode == 'Bank'">
                            Bank: {{ item.bank}} <br> Bank Code:
                            {{ item.bank_code }}
                          </td>
                          <td></td>
                          <td  width="250px" v-if="item.mode == 'bKash'">
                            Bkash From: {{ item.from_bkash }} To Bkash:
                            {{ item.to_bkash }}
                          </td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                </v-card>
              </v-col>
            </template>
            <!-- <template v-if="data.from_bKash">
              <v-col cols="6" sm="6" md="6">From Bkash </v-col>
              <v-col cols="6" sm="6" md="6">
                {{ data.from_bKash }}
              </v-col>
              <v-col cols="6" sm="6" md="6"> To Bkash </v-col>
              <v-col cols="6" sm="6" md="6">
                {{ data.to_bKash }}
              </v-col>
            </template> -->
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  head: {
    title: "",
  },
  props: ["data"],
  components: {},
  data() {
    return {};
  },
  computed: {
    isOpened() {
      return this.$store.getters.viewmodal;
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {
    closeModal() {
      this.$store.commit("SET_VIEW_MODAL", false);
    },
  },
};
</script>

<style>
</style>
