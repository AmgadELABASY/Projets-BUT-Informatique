
public abstract class Operation extends Expression {
	

	/*
	 * la classe Operation a des objets de type Expression
	 */
	
	private Expression operande1;
	
	private Expression operande2;
	
	
	public Operation(Expression op1, Expression op2) {
		this.operande1 = op1;
		this.operande2 = op2;
	}
	
	
	public Expression getOperande1() {
		return this.operande1;
	}
	
	
	public Expression getOperande2() {
		return this.operande2;
	}
	

	public abstract int valeur();
	

		
}
