package SellShares.src.main.java.com.cs673.t1.model;

import java.math.BigDecimal;

/**
 * 
 * @author Mubarak
 *
 */
public class Overview {

	private String username;
	private String portfolio_name;
	private String symbol;
	private String company_name;
	private BigDecimal lastprice;
	private BigDecimal change;
	private BigDecimal percent_change;
	private int volume;

	public Overview(String username, String portfolio_name, String symbol, String company_name, BigDecimal lastprice,
			BigDecimal change, BigDecimal percent_change, int volume) {
		super();
		this.username = username;
		this.portfolio_name = portfolio_name;
		this.symbol = symbol;
		this.company_name = company_name;
		this.lastprice = lastprice;
		this.change = change;
		this.percent_change = percent_change;
		this.volume = volume;
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

	public String getSymbol() {
		return symbol;
	}

	public void setSymbol(String symbol) {
		this.symbol = symbol;
	}

	public String getCompany_name() {
		return company_name;
	}

	public void setCompany_name(String company_name) {
		this.company_name = company_name;
	}

	public BigDecimal getLastprice() {
		return lastprice;
	}

	public void setLastprice(BigDecimal lastprice) {
		this.lastprice = lastprice;
	}

	public BigDecimal getChange() {
		return change;
	}

	public void setChange(BigDecimal change) {
		this.change = change;
	}

	public BigDecimal getPercent_change() {
		return percent_change;
	}

	public void setPercent_change(BigDecimal percent_change) {
		this.percent_change = percent_change;
	}

	public int getVolume() {
		return volume;
	}

	public void setVolume(int volume) {
		this.volume = volume;
	}

	@Override
	public String toString() {
		return "Overview [username=" + username + ", portfolio_name=" + portfolio_name + ", symbol=" + symbol
				+ ", company_name=" + company_name + ", lastprice=" + lastprice + ", change=" + change
				+ ", percent_change=" + percent_change + ", volume=" + volume + "]";
	}

}
