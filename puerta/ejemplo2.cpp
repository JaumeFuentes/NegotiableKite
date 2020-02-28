
#include <iostream>
#include <sys/io.h>
#include <stdlib.h>


using namespace std;
int opcion;

int main(void)
{
	if(ioperm(0x378,1,1)){
		cout<<"error payo";
		exit(1);
	}
	/*do{
		cin>>opcion;	
		if(opcion==0)
			outb(0x00,0x378);
		if(opcion==1)
			outb(0x01,0x378);
	}
	while(opcion!=2);*/
	outb(0x01,0x378);
	
	
	exit(0);
    
    
}
