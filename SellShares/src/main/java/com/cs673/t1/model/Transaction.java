package SellShares.src.main.java.com.cs673.t1.model;

import java.math.BigDecimal;
import java.time.LocalDateTime;

/**
 * 
 * @author Mubarak
 *
 */
public class Transaction {

	private int transactionid;
	private String portfolio_name;
	private String username;
	private String company_name;
	private String symbol;
	private String type;
	private LocalDateTime timestamp;
	private int shares;
	private BigDecimal price;
	private BigDecimal amount;

	public Transaction(int transactionid, String portfolio_name, String username, String company_name, String symbol,
			String type, LocalDateTime timestamp, int shares, BigDecimal price, BigDecimal amount) {
		super();
		this.transactionid = transactionid;
		this.portfolio_name = portfolio_name;
		this.username = username;
		this.company_name = company_name;
		this.symbol = symbol;
		this.type = type;
		this.timestamp = timestamp;
		this.shares = shares;
		this.price = price;
		this.amount = amount;
	}

	public int getTransactionid() {
		return transactionid;
	}

	public void setTransactionid(int transactionid) {
		this.transactionid = transactionid;
	}

	public String getPortfolio_name() {
		return portfolio_name;
	}

	public void setPortfolio_name(String portfolio_name) {
		this.portfolio_name = portfolio_name;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getCompany_name() {
		return company_name;
	}

	public void setCompany_name(String company_name) {
		this.company_name = company_name;
	}

	public String getSymbol() {
		return symbol;
	}

	public void setSymbol(String symbol) {
		this.symbol = symbol;
	}

	public String getType() {
		return type;
	}

	public void setType(String type) {
		this.type = type;
	}

	public LocalDateTime getTimestamp() {
		return timestamp;
	}

	public void setTimestamp(LocalDateTime timestamp) {
		this.timestamp = timestamp;
	}

	public int getShares() {
		return shares;
	}

	public void setShares(int shares) {
		this.shares = shares;
	}

	public BigDecimal getPrice() {
		return price;
	}

	public void setPrice(BigDecimal price) {
		this.price = price;
	}

	public BigDecimal getAmount() {
		return amount;
	}

	public void setAmount(BigDecimal amount) {
		this.amount = amount;
	}

	@Override
	public String toString() {
		return "Transaction [transactionid=" + transactionid + ", portfolio_name=" + portfolio_name + ", username="
				+ username + ", company_name=" + company_name + ", symbol=" + symbol + ", type=" + type + ", timestamp="
				+ timestamp + ", shares=" + shares + ", price=" + price + ", amount=" + amount + "]";
	}

}
