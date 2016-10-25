public class Main { public static void main(String[] args) { System.out.print(factorialRecur(5)); }public static int factorialRecur(int n) {
	if(n==0){
		return 1;
    } else {
    	return factorialRecur(n-1) * n;
    }
}}