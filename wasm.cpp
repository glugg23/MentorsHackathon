#include <iostream>
#include "restclient-cpp/connection.h"
#include "restclient-cpp/restclient.h"

#include "PRIVATE.h"

int main() {
    RestClient::init();
    RestClient::Connection* conn = new RestClient::Connection("https://api.teller.io");

    RestClient::HeaderFields headers;
    headers["Authorization"] = "Bearer " + AUTH_CODE;
    conn->SetHeaders(headers);

    RestClient::Response r = conn->get("/accounts/" + ACCOUNT_ID + "/transactions");
    std::cout << r.body << std::endl;

    return 0;
}