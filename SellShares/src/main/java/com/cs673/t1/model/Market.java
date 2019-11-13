package SellShares.src.main.java.com.cs673.t1.model;

import java.math.BigDecimal;

/**
 * 
 * @author Mubarak
 *
 */
public class Market {

	private String symbol;
	private String company_name;
	private String exchange;
	private BigDecimal nine_2_price;
	private String currency;
	private BigDecimal current_price;
	private BigDecimal usd_price;
	private BigDecimal change;
	private BigDecimal percent_change;
	private int volume;

	public Market(String symbol, String company_name, String exchange, BigDecimal nine_2_price, String currency,
			BigDecimal current_price, BigDecimal usd_price, BigDecimal change, BigDecimal percent_change, int volume) {
		super();
		this.symbol = symbol;
		this.company_name = company_name;
		this.exchange = exchange;
		this.nine_2_price = nine_2_price;
		this.currency = currency;
		this.current_price = current_price;
		this.usd_price = usd_price;
		this.change = change;
		this.percent_change = percent_change;
		this.volume = volume;
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

	public String getExchange() {
		return exchange;
	}

	public void setExchange(String exchange) {
		this.exchange = exchange;
	}

	public BigDecimal getNine_2_price() {
		return nine_2_price;
	}

	public void setNine_2_price(BigDecimal nine_2_price) {
		this.nine_2_price = nine_2_price;
	}

	public String getCurrency() {
		return currency;
	}

	public void setCurrency(String currency) {
		this.currency = currency;
	}

	public BigDecimal getCurrent_price() {
		return current_price;
	}

	public void setCurrent_price(BigDecimal current_price) {
		this.current_price = current_price;
	}

	public BigDecimal getUsd_price() {
		return usd_price;
	}

	public void setUsd_price(BigDecimal usd_price) {
		this.usd_price = usd_price;
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
		return "Market [symbol=" + symbol + ", company_name=" + company_name + ", exchange=" + exchange
				+ ", nine_2_price=" + nine_2_price + ", currency=" + currency + ", current_price=" + current_price
				+ ", usd_price=" + usd_price + ", change=" + change + ", percent_change=" + percent_change + ", volume="
				+ volume + "]";
	}

}
