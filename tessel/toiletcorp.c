#include <stdio.h>
#include <curl/curl.h>
#include <string.h>
int main(){
	char str[1024];
	char req[1024];
	char *key, *value;
	CURL *curl;
	while(scanf("%s", str)){
		curl = curl_easy_init();
		printf("Got: %s\n", str);
		key = strtok(str, ":");
		value = strtok(NULL, ":");
		sprintf(req, "http://www.centraledev.com:2345/?key=%s&value=%s", key, value);
		printf("Request to: %s\n", req);
		curl_easy_setopt(curl, CURLOPT_URL, req);
		curl_easy_perform(curl);
		curl_easy_cleanup(curl);
	}
	return 0;
}
