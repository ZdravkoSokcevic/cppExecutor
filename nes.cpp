#include<iostream>
using namespace std;

int main(int argc,char** argv)
{
    for(int x=0;x<argc;x++)
    {
        // cout<<argv[x]<<"\n";
    }
    // cout<<argv[1]<<"\n";
    int x=0;
    char c;
    int arr[100];
    int *p=arr;
    int k=0;
    arr[2]=552;
    cout<<*(p+2);
    while(( c=argv[1][x])!='\0')
    {
        // cout<<argv[1][x++];
        if(c!=',')
           *(p+k)=int(c);  
            x++;
            k++ ;
    }
    cout<<"Array contains: ";
    for(int x=0;x<k;x++)
    {
        cout<<char(arr[x]);
    }
    // cout<<argv[1][6]<<"\n";
    // cout << 1 or 0;
    
    exit;
}