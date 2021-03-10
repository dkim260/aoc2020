import java.util.*;
public class P3_P10137_TheTrip {
	public class dollarsAndCents 
	{
		public int dollars;
		public int cents;
		
		public dollarsAndCents (String input)
		{
			String dollarsCentsStringSplit [] = input.split(".");
			dollars = Integer.parseInt(dollarsCentsStringSplit[0]);
			cents = Integer.parseInt(dollarsCentsStringSplit[1]);
		}
	}

	public static void main(String[] args) {
		Scanner input = new Scanner (System.in);
		
		int n = -1;
		
		//get first input
		n = input.nextInt();
		while (n != 0) 
		{			
			//create an array of n indexes
			double expenses [] = new double [n];
			double howMuchShouldPay = 0;
			
			//each next input will be the expense of student n
			for (int x =0; x< n; x++)
			{
				expenses[x]=input.nextDouble();
				
				//This will calculate the total spent for the trip
				howMuchShouldPay += expenses[x];
			}
			
			//Divide total expense by n people. Had to multiply n by 1.00 because n is an integer.
			
			//Rounding massage
			howMuchShouldPay = Math.round(howMuchShouldPay*100.00);
			howMuchShouldPay /= 100.00;
			howMuchShouldPay /= n*1.0;
			howMuchShouldPay = Math.round(howMuchShouldPay*100.00);
			howMuchShouldPay /= 100.00;
			
			double equalizeStack=0;
			for (int x =0; x<n ;x++)
			{
				double equalizeBuffer=0;
				if (expenses[x]<howMuchShouldPay)
				{
					for (int y=x+1; y<n; y++)
					{
						equalizeBuffer += Math.abs(expenses[x]-howMuchShouldPay);
						expenses[x]+=equalizeBuffer;
						if (expenses[y]>howMuchShouldPay)//It should be the difference, not just greater
						{
							expenses[y]=expenses[y]-equalizeBuffer;
							equalizeStack+=equalizeBuffer;
							equalizeBuffer=0;
							y=n;
						}
					}
				}
			}
			System.out.println(equalizeStack);

			n = input.nextInt();
		}
		input.close();

	}

}
