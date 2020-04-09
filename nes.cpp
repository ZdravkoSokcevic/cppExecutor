#include<iostream>
using namespace std;

int main(int argc,char** argv)
{
    for(int x=0;x<argc;x++)
    {
        cout<<argv[x]<<"\n";
    }
    
    exit;
}
