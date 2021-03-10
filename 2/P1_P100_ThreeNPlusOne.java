import java.util.*;
public class P1_P100_ThreeNPlusOne {
	static int cycleCount=0;
	
	public static int calculateCycles (int x)
	{
		cycleCount++;
		if (x == 1)
			return cycleCount;		
		else if (x % 2 == 0)
		{
			return (calculateCycles(x/2));
		}
		else
		{
			return (calculateCycles((x*3)+1));			
		}
	}

	public static void main(String[] args) {
		Scanner input = new Scanner(System.in);
		int j=0;
		int i=0;
		
		int maxNumOfCycles;
		
		while(input.hasNextInt()) 
		{
			cycleCount=0;
			maxNumOfCycles=0;
			
			//Read input from the two integers
			i = input.nextInt();
			j = input.nextInt();
	
			if (i <=j) {
				//Parse through each integer between the range
				for (int x=i; x<=j; x++)
				{
					//Calculate how many cycles it takes for x.
					calculateCycles(x);
					
					//Store the bigger number (current max, calculated max) into maxNumOfCycles for each x.
					if (maxNumOfCycles <= cycleCount)
						maxNumOfCycles = cycleCount;
					
					//Reset the cycle count.
					cycleCount=0;
				}
				System.out.printf("%d %d %d\n",i, j, maxNumOfCycles);
			}
			else
			{
				//Parse through each integer between the range
				for (int x=j; x<=i; x++)
				{
					//Calculate how many cycles it takes for x.
					calculateCycles(x);
					
					//Store the bigger number (current max, calculated max) into maxNumOfCycles for each x.
					if (maxNumOfCycles <= cycleCount)
						maxNumOfCycles = cycleCount;
					
					//Reset the cycle count.
					cycleCount=0;
				}
				System.out.printf("%d %d %d\n",i, j, maxNumOfCycles);				
			}
		}
		
		input.close();
		
	}

}
