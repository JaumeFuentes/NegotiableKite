
#include <iostream>
#include <sys/io.h>
#include <stdlib.h>


using namespace std;

int main(void)
{
	if(ioperm(0x378,1,1)){
		cout<<"error payo";
		exit(1);
	}
	outb(0x00,0x378);
	
	exit(0);
    
    
}
