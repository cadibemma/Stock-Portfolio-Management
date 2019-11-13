package SellShares.src.main.java.com.cs673.t1.model;

import java.math.BigDecimal;

/**
 * 
 * @author Mubarak
 *
 */
public class Cash {

	private int id;
	private String username;
	private String portfolio_name;
	private BigDecimal amount;

	public Cash(int id, String username, String portfolio_name, BigDecimal amount) {
		super();
		this.id = id;
		this.username = username;
		this.portfolio_name = portfolio_name;
		this.amount = amount;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getPortfolio_name() {
		return portfolio_name;
	}

	public void setPortfolio_name(String portfolio_name) {
		this.portfolio_name = portfolio_name;
	}

	public BigDecimal getAmount() {
		return amount;
	}

	public void setAmount(BigDecimal amount) {
		this.amount = amount;
	}

	@Override
	public String toString() {
		return "Cash [id=" + id + ", username=" + username + ", portfolio_name=" + portfolio_name + ", amount=" + amount
				+ "]";
	}

}
