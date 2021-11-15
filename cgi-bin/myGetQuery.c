#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#define MAX_ENTRIES 10000
#define LF 10
#define CR 13
#define QUERY_LEN 1024
#define PAIR_LEN 512

char *getenv();
char x2c(char *what);
void unescape_url(char *url);
void plustospace(char *str);
void myParse(char* str);
char* getName(char* str);
char* getValue(char* str);

int main(int argc, char *argv[]) {
   printf("Content-type: text/html%c%c",10,10);


    if(strcmp(getenv("REQUEST_METHOD"),"GET")!=0 ) {
        printf("This script should be referenced with a METHOD of GET.\n");
        exit(-1);
    }

    if(strcmp(getenv("REQUEST_METHOD"),"GET")==0 ) {
        char* QueryString=(char*)malloc(sizeof(char)*QUERY_LEN);
        strcpy(QueryString,getenv("QUERY_STRING"));
       
        myParse(QueryString);
        exit(1);
    }

  return 0;
}



void myParse(char* QueryString){

    int pairNum=1;

    for(int i=0;i<strlen(QueryString);i++){
        if(QueryString[i]=='&') pairNum++;
    }
   
    char COPY_STRING[1024]={'\0',};
    strcpy(COPY_STRING,QueryString);
    plustospace(COPY_STRING);

    int i=0;
    char* pArr[PAIR_LEN]={NULL,};
    char** nArr;
    char** vArr;

    nArr=(char**)malloc(sizeof(char*)*pairNum);
    for(int i=0;i<pairNum;i++)
        nArr[i]=(char*)malloc(sizeof(char)*PAIR_LEN+1);
    
    vArr=(char**)malloc(sizeof(char*)*pairNum);
    for(int i=0;i<pairNum;i++)
        vArr[i]=(char*)malloc(sizeof(char)*PAIR_LEN+1);


    char *ptr = strtok(COPY_STRING, "&");   
    while (ptr != NULL)           
    {
        pArr[i] = ptr;             
        i++;                      
        ptr = strtok(NULL, "&");   
    }

   

    
    for(int i=0;i<pairNum;i++){
        strcpy(nArr[i],getName(pArr[i]));
        strcpy(vArr[i],getValue(pArr[i]));
    }
  
    
    printf("<H1>Query Results</H1>");
    printf("You submitted the following name/value pairs:<p>%c",10);
    printf("<ul>%c",10);
    for(int i=0; i <pairNum; i++){
        printf("<li> <code>%s = %s</code>%c",nArr[i],vArr[i],10);
    }
    printf("</ul>%c",10);


    return;
}


char* getName(char* str){
    char COPIED[PAIR_LEN]={'\0',};
    strcpy(COPIED,str);
    char* res=(char*)malloc(sizeof(char)*PAIR_LEN+1);
    int idx=0;
    for(idx=0;COPIED[idx]!='=';idx++){
        res[idx]=COPIED[idx];
    }
    return res;
}

char* getValue(char* str){
    char COPIED[PAIR_LEN]={'\0',};
    strcpy(COPIED,str);
    char* res=(char*)malloc(sizeof(char)*PAIR_LEN+1);
    int idx=0;
    for(idx=0;idx<strlen(COPIED);idx++){
       if(COPIED[idx]=='=')
            break;
    }
    int i=0,j=0;
    for(i=idx+1,j=0;i<strlen(COPIED);i++,j++){
        res[j]=COPIED[i];
    }
    unescape_url(res);
    return res;
}


char x2c(char *what) {
    register char digit;

    digit = (what[0] >= 'A' ? ((what[0] & 0xdf) - 'A')+10 : (what[0] - '0'));
    digit *= 16;
    digit += (what[1] >= 'A' ? ((what[1] & 0xdf) - 'A')+10 : (what[1] - '0'));
    return(digit);
}

void unescape_url(char *url) {
    register int x,y;

    for(x=0,y=0;url[y];++x,++y) {
        if((url[x] = url[y]) == '%') {
            url[x] = x2c(&url[y+1]);
            y+=2;
        }
    }
    url[x] = '\0';
}

void plustospace(char *str) {
    register int x;

    for(x=0;str[x];x++) if(str[x] == '+') str[x] = ' ';
}
