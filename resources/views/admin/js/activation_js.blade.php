@push('script')
    <script>
        const activationTableElement = document.querySelector(".display-plan");
        let renewalPrice = 0
        let renewalBtn = document.querySelector("#renewal-btn");
        let renewalPriceEl = document.querySelector(".renewal-price");
        let plan_id = null;
        const alertEl = document.querySelector(".alert-el")

        function payWithMonnify() {
            MonnifySDK.initialize({
                amount: renewalPrice,
                currency: "NGN",
                reference: new String(new Date().getTime()),
                customerFullName: "{{ companyInfo()->company_name }}",
                customerEmail: "{{ companyInfo()->company_email }}",
                apiKey: "MK_PROD_QSXL9D2HBC",
                contractCode: "587163315485",
                paymentDescription: "Account Renewal",
                metadata: {
                    companyName: "{{ companyInfo()->company_name }}",
                },
                onLoadStart: () => {
                    console.log("loading has started")
                },
                onLoadComplete: () => {
                    console.log("SDK is UP")
                },
                onComplete: function(response) {
                    console.log(response)
                    //save the transaction
                    saveTransaction(response?.transactionReference + "|" + response?.paymentReference);
                    fetchPlan()
                },
                onClose: function(data) {
                    console.log(data)
                },
            })
        }


        const saveTransaction = async (trx_id) => {
            const endpoint = "{{ env('API_BASE_URL') }}/api/subscription/renewal";
            const payload = {
                trx_id: trx_id,
                uuid: "{{ env('ACTIVATION_KEY') }}",
                plan_id: plan_id
            };

            try {
                const response = await fetch(endpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                if (data) {
                    alertEl.innerHTML =
                        `<div class="alert alert-${data.status === "success" ? "success" : "danger"}">
                    ${data?.message}
                </div>`;
                    console.log(data);
                }

            } catch (err) {
                console.error("Error saving transaction:", err);
            }
        };


        const fetchPlan = async () => {
            const uuid = "{{ env('ACTIVATION_KEY') }}";
            if (!uuid) {
                console.log("Error: Account not activated. UUID not found!");
                alertEl.innerHTML =
                    `<div class="alert alert-danger">UUID not found, Contact technical team!</div>`;
                return;
            }

            const endpoint = "{{ env('API_BASE_URL') }}/api/subscription/me";

            try {
                const response = await fetch(`${endpoint}?uuid=${uuid}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();

                if (data) {
                    renewalPrice = parseInt(data?.subscription?.plan?.current_price);
                    if (data?.subscription?.status !== "active") {
                        renewalBtn.style.display = "block";
                    }
                    console.log(data);
                    plan_id = data?.subscription?.plan?.id;
                    renewalPriceEl.innerHTML =
                        `Renewal Price: <span class="font-weight-bold">&#8358; 
                ${Number(data?.subscription?.plan?.current_price).toLocaleString("en-NG")}</span>`;

                    activationTableElement.innerHTML = `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Days left</th>
                            <th>Renewal Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${data?.subscription?.plan?.name}</td>
                            <td>${data?.subscription?.start_date}</td>
                            <td>${data?.subscription?.end_date}</td>
                            <td>${data?.subscription?.days_left}</td>
                            <td class="text-uppercase">
                                <small class="badge bg-${data?.subscription?.status === "active" ? "success" : "danger"}">
                                    ${data?.subscription?.status}
                                </small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            `;
                }

            } catch (error) {
                console.error("Error fetching plan:", error);
            }
        };

        fetchPlan();
    </script>
@endpush
