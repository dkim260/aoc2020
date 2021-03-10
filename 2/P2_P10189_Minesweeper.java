import java.util.*;
public class P2_P10189_Minesweeper {

	public static void main(String[] args) {
		Scanner input = new Scanner(System.in);
		int numOfFields=0;
		
		while(input.hasNextInt()) 
		{
			int height = input.nextInt();
			int width = input.nextInt();
			
			if (width !=0 && height!=0)
			{
				char playfield[][] = new char [height][width];
				String outfield [][] = new String [height][width];
				
				for (int y=0; y<height; y++)
				{
					String x = input.next();
					for (int a=0; a<x.length(); a++)
					{
						playfield[y][a]=x.charAt(a);
						outfield[y][a]="0";				
						if (playfield[y][a]=='*')
						{
							outfield[y][a]="*";
						}
					}
				}
				if (numOfFields !=0)
					System.out.println();
				System.out.println("Field #" + (++numOfFields)+":");
				for (int y=0; y<height; y++)
				{
					for (int x=0; x<width; x++)
					{
						if (playfield[y][x]==('*')) 
						{
							if (!(x-1<0) && !outfield[y][x-1].equals("*")) outfield[y][x-1] = Integer.toString(Integer.parseInt(outfield[y][x-1])+1);
							if (!(x+1>=width)&& !outfield[y][x+1].equals("*")) outfield[y][x+1] = Integer.toString(Integer.parseInt(outfield[y][x+1])+1);
							if (!(y-1<0)&& !outfield[y-1][x].equals("*")) outfield[y-1][x] = Integer.toString(Integer.parseInt(outfield[y-1][x])+1);
							if (!(y+1>=height)&& !outfield[y+1][x].equals("*")) outfield[y+1][x] = Integer.toString(Integer.parseInt(outfield[y+1][x])+1);

							if ((!(x-1<0) &&(!(y-1<0))&& !outfield[y-1][x-1].equals("*"))) outfield[y-1][x-1] = Integer.toString(Integer.parseInt(outfield[y-1][x-1])+1);
							if ((!(x-1<0) &&(!(y+1>=height))&& !outfield[y+1][x-1].equals("*"))) outfield[y+1][x-1] = Integer.toString(Integer.parseInt(outfield[y+1][x-1])+1);
							if ((!(x+1>=width) &&(!(y-1<0))&& !outfield[y-1][x+1].equals("*"))) outfield[y-1][x+1] = Integer.toString(Integer.parseInt(outfield[y-1][x+1])+1);
							if ((!(x+1>=width) &&(!(y+1>=height))&& !outfield[y+1][x+1].equals("*"))) outfield[y+1][x+1] = Integer.toString(Integer.parseInt(outfield[y+1][x+1])+1);
						}
					}
				}				
				for (int y=0; y<height; y++)
				{
					for (int x=0; x<width; x++) 
					{
						System.out.print(outfield[y][x]);
					}
					System.out.println();
				}
			}
		}		
		input.close();
	}

}
